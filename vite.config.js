import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/custom.css",
                "resources/css/app.css",
                "resources/css/components/index-design.css",
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/js/components/datepicker.js",
                "resources/js/components/fancybox.js",
            ],
            refresh: true,
        }),
    ],
});
