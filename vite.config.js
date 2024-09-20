import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/build',  // Ensure this matches the deployment path
        assetsDir: '',           // This will place the assets directly in the build folder
        rollupOptions: {
            output: {
                // Ensure assets are correctly linked
                assetFileNames: (assetInfo) => {
                    let extType = assetInfo.name.split('.').pop();
                    if (/css|js/.test(extType)) {
                        return `[name].[hash].[ext]`;
                    }
                    return `assets/[name].[hash].[ext]`;
                },
            },
        },
    },
});
