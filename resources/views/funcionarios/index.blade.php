@extends('layouts.app')

@section('title', 'Lista de Funcionários')

@section('content')
<div x-data="funcionariosApp()" class="fade-in">
    <!-- Cabeçalho com botão de adicionar -->
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users me-2"></i>Funcionários</h2>
            <p class="text-muted">Gerencie os funcionários da empresa</p>
        </div>
        <div class="col-md-4 text-end">
            <button type="button" class="btn btn-custom btn-lg" onclick="abrirModal()">
                <i class="fas fa-plus me-2"></i>Novo Funcionário
            </button>
        </div>
    </div>

    <!-- Mensagens de alerta -->
    <div x-show="message.show" x-transition class="alert alert-dismissible fade show" 
         :class="message.type === 'success' ? 'alert-success' : 'alert-danger'">
        <span x-text="message.text"></span>
        <button type="button" class="btn-close" @click="message.show = false"></button>
    </div>

    <!-- Filtros avançados -->
    <div class="row mb-3 align-items-end g-2">
        <div class="col-md-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" placeholder="Buscar por nome" x-model="filtroNome">
        </div>
        <div class="col-md-3">
            <label class="form-label">Email</label>
            <input type="text" class="form-control" placeholder="Buscar por email" x-model="filtroEmail">
        </div>
        <div class="col-md-2">
            <label class="form-label">CPF</label>
            <input type="text" class="form-control" placeholder="Buscar por CPF" x-model="filtroCpf">
        </div>
        <div class="col-md-2">
            <label class="form-label">Cargo</label>
            <input type="text" class="form-control" placeholder="Buscar por cargo" x-model="filtroCargo">
        </div>
        <div class="col-md-2">
            <label class="form-label">Status</label>
            <select class="form-select" x-model="filtroStatus">
                <option value="">Todos</option>
                <option value="ativo">Ativo</option>
                <option value="inativo">Inativo</option>
            </select>
        </div>
    </div>

    <!-- Tabela de funcionários -->
    <div class="card shadow">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Lista de Funcionários</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>CPF</th>
                            <th>Cargo</th>
                            <th>Data Admissão</th>
                            <th>Salário</th>
                            <th>Status</th>
                            <th width="150">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="funcionario in funcionariosFiltrados()" :key="funcionario.id">
                            <tr>
                                <td x-text="funcionario.nome"></td>
                                <td x-text="funcionario.email"></td>
                                <td x-text="formatCPF(funcionario.cpf)"></td>
                                <td x-text="funcionario.cargo || '-' "></td>
                                <td x-text="funcionario.dataAdmissao ? formatDate(funcionario.dataAdmissao) : '-' "></td>
                                <td x-text="funcionario.salario ? formatCurrency(funcionario.salario) : '-' "></td>
                                <td x-text="funcionario.status === 'inativo' ? 'Inativo' : 'Ativo'" class="fw-bold" :class="funcionario.status === 'inativo' ? 'text-danger' : 'text-success'"></td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary me-1"
                                            @click="editarFuncionario(funcionario.id)" title="Editar"
                                            x-show="funcionario.status === 'ativo'">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger"
                                            @click="deleteFuncionario(funcionario.id)" title="Excluir"
                                            x-show="funcionario.status === 'ativo'">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-success"
                                            @click="reativarFuncionario(funcionario.id)" title="Reativar"
                                            x-show="funcionario.status === 'inativo'">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="funcionarios.length === 0">
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                Nenhum funcionário cadastrado
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para cadastro/edição de funcionário -->
    <div class="modal fade" id="funcionarioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Novo Funcionário</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="funcionarioForm">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Nome *</label>
                                <input type="text" class="form-control" id="nome" required>
                                <div class="text-danger small" id="erro-nome"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">CPF *</label>
                                <input type="text" class="form-control" id="cpf" maxlength="14" required>
                                <div class="text-danger small" id="erro-cpf"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Email *</label>
                                <input type="email" class="form-control" id="email" required>
                                <div class="text-danger small" id="erro-email"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Cargo</label>
                                <input type="text" class="form-control" id="cargo">
                                <div class="text-danger small" id="erro-cargo"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data de Admissão</label>
                                <input type="date" class="form-control" id="dataAdmissao">
                                <div class="text-danger small" id="erro-dataAdmissao"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Salário</label>
                                <input type="number" step="0.01" class="form-control" id="salario" min="0">
                                <div class="text-danger small" id="erro-salario"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-custom" id="btnSalvar">
                            <span class="spinner-border spinner-border-sm me-2" style="display: none;" id="spinner"></span>
                            <span id="btnTexto">Cadastrar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let funcionarios = @json($funcionarios);
let isEditing = false;
let editingId = null;
let modal = null;

document.addEventListener('DOMContentLoaded', function() {
    modal = new bootstrap.Modal(document.getElementById('funcionarioModal'));
    
    document.getElementById('funcionarioForm').addEventListener('submit', function(e) {
        e.preventDefault();
        salvarFuncionario();
    });
    
    document.getElementById('cpf').addEventListener('input', function(e) {
        this.value = formatCPFInput(this.value);
    });
});

function funcionariosApp() {
    return {
        funcionarios: funcionarios,
        filtroNome: '',
        filtroEmail: '',
        filtroCpf: '',
        filtroCargo: '',
        filtroStatus: '',
        message: {
            show: false,
            text: '',
            type: 'success'
        },

        async deleteFuncionario(id) {
            if (!confirm('Tem certeza que deseja excluir este funcionário?')) {
                return;
            }

            try {
                const response = await fetch(`/funcionarios/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    this.showMessage(data.message, 'success');
                    // Atualizar status localmente, não remover do array
                    const index = this.funcionarios.findIndex(f => f.id === id);
                    if (index !== -1) {
                        this.funcionarios[index].status = 'inativo';
                    }
                    funcionarios = this.funcionarios;
                } else {
                    this.showMessage('Erro ao excluir funcionário', 'error');
                }
            } catch (error) {
                this.showMessage('Erro ao excluir funcionário', 'error');
            }
        },

        async reativarFuncionario(id) {
            if (!confirm('Deseja reativar este funcionário?')) {
                return;
            }
            try {
                const response = await fetch(`/funcionarios/${id}/reativar`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                const data = await response.json();
                if (response.ok) {
                    this.showMessage(data.message, 'success');
                    const index = this.funcionarios.findIndex(f => f.id === id);
                    if (index !== -1) {
                        this.funcionarios[index].status = 'ativo';
                    }
                    funcionarios = this.funcionarios;
                } else {
                    this.showMessage('Erro ao reativar funcionário', 'error');
                }
            } catch (error) {
                this.showMessage('Erro ao reativar funcionário', 'error');
            }
        },

        showMessage(text, type) {
            this.message = {
                show: true,
                text: text,
                type: type
            };

            setTimeout(() => {
                this.message.show = false;
            }, 5000);
        },

        formatCPF(cpf) {
            if (!cpf) return '';
            return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
        },

        formatDate(date) {
            if (!date) return '';
            return new Date(date).toLocaleDateString('pt-BR');
        },

        formatCurrency(value) {
            if (!value) return '';
            return new Intl.NumberFormat('pt-BR', {
                style: 'currency',
                currency: 'BRL'
            }).format(value);
        },

        funcionariosFiltrados() {
            return this.funcionarios.filter(f => {
                const nomeOk = this.filtroNome === '' || (f.nome || '').toLowerCase().includes(this.filtroNome.toLowerCase());
                const emailOk = this.filtroEmail === '' || (f.email || '').toLowerCase().includes(this.filtroEmail.toLowerCase());
                const cpfOk = this.filtroCpf === '' || (f.cpf || '').includes(this.filtroCpf.replace(/\D/g, ''));
                const cargoOk = this.filtroCargo === '' || (f.cargo || '').toLowerCase().includes(this.filtroCargo.toLowerCase());
                const statusOk = this.filtroStatus === '' || (f.status || 'ativo') === this.filtroStatus;
                return nomeOk && emailOk && cpfOk && cargoOk && statusOk;
            });
        },

        editarFuncionario(id) {
            console.log('Editando funcionário:', id);
            fetch(`/funcionarios/${id}/edit`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro ao buscar funcionário');
                    }
                    return response.json();
                })
                .then(funcionario => {
                    document.getElementById('nome').value = funcionario.nome || '';
                    document.getElementById('email').value = funcionario.email || '';
                    document.getElementById('cpf').value = funcionario.cpf || '';
                    document.getElementById('cargo').value = funcionario.cargo || '';
                    document.getElementById('dataAdmissao').value = funcionario.dataAdmissao || '';
                    document.getElementById('salario').value = funcionario.salario || '';
                    
                    isEditing = true;
                    editingId = id;
                    document.getElementById('modalTitle').textContent = 'Editar Funcionário';
                    document.getElementById('btnTexto').textContent = 'Atualizar';
                    modal.show();
                })
                .catch(error => {
                    alert('Erro ao carregar dados do funcionário');
                });
        }
    }
}

// Função para abrir modal de cadastro
function abrirModal() {
    console.log('Abrindo modal para novo funcionário');
    limparFormulario();
    isEditing = false;
    editingId = null;
    document.getElementById('modalTitle').textContent = 'Novo Funcionário';
    document.getElementById('btnTexto').textContent = 'Cadastrar';
    modal.show();
}

// Limpa o formulário do modal
function limparFormulario() {
    document.getElementById('funcionarioForm').reset();
    limparErros();
}

// Limpa mensagens de erro do formulário
function limparErros() {
    ['nome', 'email', 'cpf', 'cargo', 'dataAdmissao', 'salario'].forEach(campo => {
        document.getElementById(`erro-${campo}`).textContent = '';
    });
}

// Salva funcionário (criação ou edição)
async function salvarFuncionario() {
    const spinner = document.getElementById('spinner');
    const btnSalvar = document.getElementById('btnSalvar');
    
    spinner.style.display = 'inline-block';
    btnSalvar.disabled = true;
    limparErros();
    
    const formData = {
        nome: document.getElementById('nome').value,
        email: document.getElementById('email').value,
        cpf: document.getElementById('cpf').value.replace(/\D/g, ''),
        cargo: document.getElementById('cargo').value,
        dataAdmissao: document.getElementById('dataAdmissao').value,
        salario: document.getElementById('salario').value
    };
    
    const url = isEditing ? `/funcionarios/${editingId}` : '/funcionarios';
    const method = isEditing ? 'PUT' : 'POST';
    
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(formData)
        });

        const data = await response.json();

        if (response.ok) {
            modal.hide();
            
            // Atualizar lista
            if (isEditing) {
                const index = funcionarios.findIndex(f => f.id === editingId);
                if (index !== -1) {
                    funcionarios[index] = data.funcionario;
                }
            } else {
                funcionarios.push(data.funcionario);
            }
            
            // Trigger Alpine.js update
            Alpine.store('funcionarios', funcionarios);
            location.reload(); // Recarregar página para garantir atualização
            
        } else {
            // Exibir erros
            if (data.errors) {
                Object.keys(data.errors).forEach(campo => {
                    const errorDiv = document.getElementById(`erro-${campo}`);
                    if (errorDiv) {
                        errorDiv.textContent = data.errors[campo][0];
                    }
                });
            }
        }
    } catch (error) {
        alert('Erro ao salvar funcionário');
    }
    
    spinner.style.display = 'none';
    btnSalvar.disabled = false;
}

// Formata o input do CPF enquanto digita
function formatCPFInput(value) {
    value = value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    }
    return value;
}
</script>
@endsection
