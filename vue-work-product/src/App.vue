<script setup>
import axios from 'axios'
import { onMounted, ref } from 'vue'

// 取得したデータを格納
const files = ref([])
// エラーが発生した場合のメッセージ
const errerMessage = ref('')

// APIデータを取得する処理
const getApi = async () => {
  // errerMessageの中身をリセット
  errerMessage.value = ''

  try {
    // APIが取得できた場合の処理
    const api = await axios.get('/api/scandir.php')
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
  <ul v-if="files.length">
    <li v-for="file in files" :key="file.name">
      <a :href="file.url" target="_blank" rel="noopener noreferrer">{{ file.name }}</a>
    </li>
  </ul>
  <p v-if="errerMessage">{{ errerMessage }}</p>
</template>
<style scoped></style>
