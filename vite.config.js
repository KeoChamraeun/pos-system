import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/chart-config.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: true,
        port: 80,
        strictPort: true,
    },
    build: {
        outDir: 'public/build',
        assetsDir: '',
        manifest: true,
    },
});
