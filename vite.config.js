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
    build: {
        outDir: 'dist', // Change output to dist
        assetsDir: 'assets', // Keep assets in dist/assets
    },
});
