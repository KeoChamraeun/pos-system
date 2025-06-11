import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/bootstrap.js', // Add this line
                'resources/js/chart-config.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'dist', // Output to public/dist
        assetsDir: 'assets', // Assets go to public/dist/assets
    },
});
