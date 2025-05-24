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
                "resources/css/admin/remixicon.css",
                "resources/css/admin/lib/bootstrap.min.css",
                "resources/css/admin/lib/apexcharts.css",
                "resources/css/admin/lib/dataTables.min.css",
                "resources/css/admin/lib/editor-katex.min.css",
                "resources/css/admin/lib/editor.atom-one-dark.min.css",
                "resources/css/admin/lib/editor.quill.snow.css",
                "resources/css/admin/lib/flatpickr.min.css",
                "resources/css/admin/lib/full-calendar.css",
                "resources/css/admin/lib/jquery-jvectormap-2.0.5.css",
                "resources/css/admin/lib/magnific-popup.css",
                "resources/css/admin/lib/slick.css",
                "resources/css/admin/lib/prism.css",
                "resources/css/admin/lib/file-upload.css",
                "resources/css/admin/lib/audioplayer.css",
                "resources/css/admin/style.css",

                // Admin JS
                "resources/js/admin/lib/jquery-3.7.1.min.js",
                "resources/js/admin/lib/bootstrap.bundle.min.js",
                "resources/js/admin/lib/apexcharts.min.js",
                "resources/js/admin/lib/dataTables.min.js",
                "resources/js/admin/lib/iconify-icon.min.js",
                "resources/js/admin/lib/jquery-ui.min.js",
                "resources/js/admin/lib/jquery-jvectormap-2.0.5.min.js",
                "resources/js/admin/lib/jquery-jvectormap-world-mill-en.js",
                "resources/js/admin/lib/magnifc-popup.min.js",
                "resources/js/admin/lib/slick.min.js",
                "resources/js/admin/lib/prism.js",
                "resources/js/admin/lib/file-upload.js",
                "resources/js/admin/lib/audioplayer.js",
                "resources/js/admin/app.js",
                "resources/js/admin/homeOneChart.js",
            ],
            refresh: true,
        }),
        viteStaticCopy({
            targets: [
                {
                    src: "resources/images/**/*",
                    dest: "images",
                },

                {
                    src: "resources/js/*",
                    dest: "js",
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
