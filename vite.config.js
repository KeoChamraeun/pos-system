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
        host: true,         // Expose to network
        port: 80,           // Set to port 80 or your desired port
        strictPort: true    // Fail if port is already taken (optional)
    },
    build: {
        outDir: 'public/build',
        assetsDir: '',
        manifest: true,
    },
});
