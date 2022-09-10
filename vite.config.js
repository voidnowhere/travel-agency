import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/jquery-ui.css',
                // 'resources/js/app.js',
                'resources/js/all.js',
                'resources/js/alpinejs.js',
                'resources/js/notiflix.js',
                'resources/js/jquery.js',
                'resources/js/jquery-ui.js',
            ],
            refresh: true,
        }),
    ],
});
