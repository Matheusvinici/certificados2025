import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Input CSS e JS
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@popperjs/core': path.resolve(__dirname, 'node_modules/@popperjs/core'),
            'jquery': path.resolve(__dirname, 'node_modules/jquery'),
        }
    },
});
