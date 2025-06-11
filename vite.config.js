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
        outDir: 'public/build',  // Required for Laravel to find manifest.json
        assetsDir: '',           // Default is 'assets', but Laravel works fine with ''
        manifest: true,          // Required for ViteManifest
    },
    server: {
        host: true,
    },
});
