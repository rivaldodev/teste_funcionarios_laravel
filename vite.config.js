/**
 * Configuração do Vite para o projeto Laravel.
 * 
 * Define como os assets (CSS/JS) devem ser compilados e servidos
 * durante o desenvolvimento e na produção.
 */
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        // Plugin do Laravel para integração com Vite
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Arquivos de entrada
            refresh: true, // Recarregamento automático durante desenvolvimento
        }),
        // Plugin do Tailwind CSS
        tailwindcss(),
    ],
});
