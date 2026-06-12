import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        // Docker: bind on all interfaces so the container port is reachable
        host: process.env.VITE_HOST ?? undefined,
        // Docker: tell the browser to connect to localhost (Docker Desktop port-forward)
        hmr: process.env.VITE_HMR_HOST
            ? { host: process.env.VITE_HMR_HOST }
            : undefined,
        watch: {
            // Docker volumes on Windows/macOS need polling for file-change detection
            usePolling: process.env.VITE_POLLING === 'true',
            interval: 1000,
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
