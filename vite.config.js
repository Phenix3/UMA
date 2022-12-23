import { defineConfig } from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import inject from "@rollup/plugin-inject";

/* if you're using React */
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
	    inject({
    		$: 'jquery',
    		jQuery: 'jquery',
	    }),
	    react(),
	    symfonyPlugin(),
    ],
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.js",
                "app-front": "./assets/front/js/app.js",
                "app-agency": "./assets/agency/js/app.js"
            },
        },
    },
    resolve: {
        alias: {
            "@@": "./assets",
            "@front": "./assets/front",
        }
    },
});

