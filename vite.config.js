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
      port: 5173,   // or any port above 1024
      strictPort: true,
    },
    build: {
      outDir: 'public/build',
      assetsDir: '',
      manifest: true,
    },
  });
