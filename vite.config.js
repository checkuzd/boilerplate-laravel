import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/frontend/scss/app.scss', 'resources/frontend/js/app.js'],
            refresh: true,
        }),
    ],
});
