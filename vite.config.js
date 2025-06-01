import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/themify-icons.css",
                "resources/css/flaticon.css",
                "resources/css/bootstrap.min.css",
                "resources/css/jquery-ui.css",
                "resources/css/animate.css",
                "resources/css/nice-select.css",
                "resources/css/owl.carousel.css",
                "resources/css/owl.theme.css",
                "resources/css/slick.css",
                "resources/css/slick-theme.css",
                "resources/css/swiper.min.css",
                "resources/css/owl.transitions.css",
                "resources/css/jquery.fancybox.css",
                "resources/css/odometer-theme-default.css",
                "resources/css/style.css",
                "resources/sass/app.scss",
                "resources/js/app.js",
                "resources/js/script.js",

                // Admin CSS
                "resources/sass/admin/main.scss",

                // Admin JS
                "resources/js/admin/homeOneChart.js",
                "resources/js/admin/app.js",
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "resources/images/**/*",
                    dest: "../assets/images",
                },

                {
                    src: "resources/css/admin/lib",
                    dest: "../assets/css/admin/",
                },
                {
                    src: "resources/fonts/admin/*",
                    dest: "../assets/css/admin/fonts/",
                },

                {
                    src: "resources/js/*",
                    dest: "../assets/js",
                },
            ],
        }),
    ],
    build: {
        rollupOptions: {
            external: ["**/*.map"],
        },
    },
});
