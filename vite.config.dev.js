// === CONFIGURAÇÃO VITE PARA DESENVOLVIMENTO ===
// Sistema de Agendamentos - Vite DEV Config

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    
    // Configurações específicas para desenvolvimento
    server: {
        host: '0.0.0.0',
        port: 5173,
        hmr: {
            host: 'localhost',
            port: 5173,
        },
        watch: {
            usePolling: true,
            interval: 1000,
        },
    },
    
    // Configurações de build para desenvolvimento
    build: {
        sourcemap: true,
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    
    // Configurações de otimização
    optimizeDeps: {
        include: ['axios'],
    },
});