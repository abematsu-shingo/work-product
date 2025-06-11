<script setup>
import axios from 'axios'
import { ref } from 'vue'

// 取得したデータを格納
const files = ref([])
const errerMessage = ref('')

// APIデータを取得する処理
const getApi = async () => {
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
}
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
