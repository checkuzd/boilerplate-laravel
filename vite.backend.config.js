import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/backend/scss/app.scss',
                'resources/backend/scss/icons.scss',
                'resources/backend/js/app.js',
                'resources/backend/js/plugins.js',
            ],
            refresh: true,
            buildDirectory: '/backend',
        }),
    ],
});
