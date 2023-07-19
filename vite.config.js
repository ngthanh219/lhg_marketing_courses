import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

const ADMIN = "admin";
const CLIENT = "client";
var site = ADMIN;

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/js/admin/app.js',
                'resources/js/client/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        outDir: 'public/js/' + site + '/',
        assetsDir: '',
        rollupOptions: {
            input: {
                app: 'resources/js/' + site + '/app.js', 
            },
        },
    }
});
