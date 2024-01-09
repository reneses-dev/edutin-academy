import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                "public/build/assets/app.css",
                "public/build/assets/app.js"
            ],
            refresh: true,
        }),
    ],
});
