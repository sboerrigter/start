import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  server: {
    cors: true,
    strictPort: true,
  },
  build: {
    assetsDir: '',
    emptyOutDir: true,
    manifest: true,
    outDir: `web/wp-content/themes/theme/dist`,
    rollupOptions: {
      input: 'web/wp-content/themes/theme/scripts/theme.js',
    },
  },
  plugins: [
    {
      name: 'php',
      handleHotUpdate({ file, server }) {
        if (file.endsWith('.php')) {
          server.ws.send({ type: 'full-reload', path: '*' });
        }
      },
    },
    tailwindcss(),
  ],
});
