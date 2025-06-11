<script setup>
import axios from 'axios'
import { ref } from 'vue'

// 取得したデータの中身を格納
const files = ref([])

// データ取得する処理
const fetchFiles = async (Promise) => {
  const getData = await axios.get('/api/scandir.php')
  // console.log(getData.data.files)
  files.value = getData.data.files
}
</script>
<template>
  <h1>Work Product</h1>

  <!-- ボタンクリックでファイル取得 -->
  <button @click="fetchFiles">getFile</button>

  <!-- 取得したファイルをリスト出力 -->
  <ul>
    <li v-for="file in files">
      <a :href="file.url" target="_blank">{{ file.name }}</a>
    </li>
  </ul>
</template>
<style scoped></style>
