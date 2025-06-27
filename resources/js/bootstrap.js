/**
 * Configurações iniciais de JavaScript para Laravel.
 * 
 * Este arquivo configura bibliotecas globais como Axios para
 * requisições HTTP e outras configurações necessárias.
 */

// Importa e configura Axios para requisições HTTP
import axios from 'axios';
window.axios = axios;

// Define cabeçalho padrão para requisições AJAX
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
