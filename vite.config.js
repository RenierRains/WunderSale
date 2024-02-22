import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path'; // Ensure path is imported

export default defineConfig({
  plugins: [
    laravel([
      'resources/css/app.css',
      'resources/js/app.js',
    ]),
    vue(), // No additional options needed for this scenario
  ],
  resolve: {
    alias: {
      // Correctly alias 'vue' to include the compiler
      'vue': path.resolve(__dirname, 'node_modules/vue/dist/vue.esm-bundler.js'),
    },
  },
});
