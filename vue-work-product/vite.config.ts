import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import vueDevTools from 'vite-plugin-vue-devtools'

// https://vite.dev/config/
export default defineConfig({
  plugins: [vue(), vueDevTools()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },

  // 開発用サーバーの設定
  server: {
    // APIリクエストをPHPバックエンドに転送するプロキシ設定
    proxy: {
      // '/api' から始まるリクエストをプロキシする
      '/api': {
        // PHPファイルが動作しているWebサーバーのURLを指定
        target: 'https://lgqqi65169.rakkoserver.net',
        // '/api/scandir.php' を '/php/scandir.php' に書き換える
        rewrite: (path) => path.replace(/^\/api/, '/php'),
        // WebSocketのプロキシ設定
        ws: true,
        // オリジンヘッダーをターゲットのURLに変更する
        changeOrigin: true,
      },
    },
  },
})
