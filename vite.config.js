import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/chart-config.js', // Only import entry points here
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/dist', // Ensure this is inside public folder for Laravel
        assetsDir: 'assets',
        manifest: true,
        rollupOptions: {
            input: {
                app: 'resources/js/app.js',
                chart: 'resources/js/chart-config.js',
                style: 'resources/sass/app.scss',
            },
        },
    },
    server: {
        host: true,
    },
});
