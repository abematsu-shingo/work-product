<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref } from 'vue'

interface FileItem {
  name: string
  url: string
}
interface Api {
  result: boolean
  files: FileItem[]
  message: string
}

// 取得したデータを格納
const files = ref<FileItem[]>([])
// エラーが発生した場合のメッセージ
const errerMessage = ref<string>('')

// APIデータを取得する処理
const getApi = async (): Promise<void> => {
  // errerMessageの中身をリセット
  errerMessage.value = ''

  try {
    // APIが取得できた場合の処理
    const api = await axios.get<Api>('/api/scandir.php')
    console.log(api.data)
    if (api.data.result) {
      // apiデータのresultがtrueだった場合、取得したデータをfilesへ格納
      // scrpit内でrefの中身を操作する場合は、明示的にvalueを指定
      files.value = api.data.files
    } else {
      // apiデータのresultがfalseだった場合、messageをerrerMessageに代入
      errerMessage.value = api.data.message // 'message' => '指定されたディレクトリが見つかりません。'
    }
  } catch {
    // APIが取得できなかった場合の処理
    errerMessage.value = 'サーバー通信中にエラーが発生しました。'
  }
}

// コンポーネントマウント時にAPI取得
onMounted(() => {
  getApi()
})
</script>

<template>
  <h1>Work Product</h1>
  <!-- apiデータを取得するボタン -->
  <button @click="getApi">Get Api</button>

  <!-- 取得したデータをリスト出力 -->
  <main>
    <div v-if="files.length" class="preview"><img :src="files[0].url" /></div>
    <div class="thumbnail">
      <ul v-if="files.length">
        <li v-for="file in files" :key="file.name">
          <img :src="file.url" :title="file.name" :alt="file.name" />
        </li>
      </ul>
    </div>
    <p v-if="errerMessage">{{ errerMessage }}</p>
  </main>
</template>

<style scoped>
main {
  display: flex;
  width: 90%;
  margin: 0 auto;
}
ul {
  width: 50%;
  margin: 0 auto;
  display: grid;
  grid-template-columns: 10vw 10vw 10vw;
  grid-template-rows: 10vw 10vw 10vw;
  gap: 30px 30px;
}
li {
  display: flex;
  justify-content: center;
  align-items: center;
  list-style: none;
  border: 0.5px solid;
}
.thumbnail img {
  width: 80%;
}
.preview {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50%;
}
.preview img {
  width: 50vw;
}
</style>
