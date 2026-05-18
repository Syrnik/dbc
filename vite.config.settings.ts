import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

export default defineConfig(({ mode }) => ({
    plugins: [vue()],
    define: {
        'process.env.NODE_ENV': JSON.stringify(mode),
    },
    build: {
        lib: {
            entry: 'src/settings/index.ts',
            name: 'ShopDbcPluginSettings',
            formats: ['umd'],
            fileName: () => 'settings.js',
        },
        outDir: 'js',
        emptyOutDir: false,
    },
}))
