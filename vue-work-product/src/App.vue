<script setup>
import axios from 'axios'
import { ref } from 'vue'

// 取得したデータを格納
const files = ref([])

// APIデータを取得する処理
const getApi = async () => {
  const api = await axios.get('/api/scandir.php')

  // 取得したデータをfilesへ格納
  // scrpit内でrefの中身を操作する場合は、明示的にvalueを指定
  files.value = api.data.files
}
</script>
<template>
  <h1>Work Product</h1>
  <!-- apiデータを取得するボタン -->
  <button @click="getApi">Get Api</button>

  <!-- 取得したデータをリスト出力 -->
  <ul>
    <li v-for="file in files">
      <a :href="file.url">{{ file.name }}</a>
    </li>
  </ul>
</template>
<style scoped></style>
