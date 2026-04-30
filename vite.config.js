import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/add-question.css',
                'resources/css/dashboard.css',
                'resources/css/leaderboard.css',
                'resources/css/results.css',
                'resources/css/student-dashboard.css',
                'resources/css/style.css',
                'resources/css/welcome.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
