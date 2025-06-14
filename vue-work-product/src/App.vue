<script setup lang="ts">
import axios from 'axios'
import { onMounted, ref, TransitionGroup, watch } from 'vue'

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
    // console.log(api.data)
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

// previewの画像をランダム表示
let previewUrl = ref<string>('')
let previewName = ref<string>('')
const setRandomPreview = () => {
  if (files.value.length) {
    const rand = Math.floor(Math.random() * files.value.length)
    previewUrl.value = files.value[rand].url
    previewName.value = files.value[rand].name
  }
}

// コンポーネントマウント時にAPI取得
onMounted(() => {
  getApi()
})

// filesが更新されたらプレビュー更新
watch(files, () => {
  setRandomPreview()
})

const showPreview = (event: MouseEvent) => {
  // console.log((event.currentTarget as HTMLElement).querySelector('img').src)
  const targetElement = event.currentTarget as HTMLElement
  const imgElement = targetElement.querySelector('img')
  // imgタグはnullの(生成されていない)可能性があるため、if分岐で明記
  if (imgElement) {
    // imgタグがあった場合は、srcの取得
    const imgUrl = imgElement.src
    const imgName = imgElement.alt
    previewUrl.value = imgUrl
    previewName.value = imgName
  }
}
</script>

<template>
  <h1>Work Product</h1>
  <!-- apiデータを取得するボタン -->
  <!-- <button @click="getApi">Get Api</button> -->

  <!-- 取得したデータをリスト出力 -->
  <main>
    <!-- 古い要素が消えるアニメーションを追加することで、画像切り替わり時のチラツキ改善 -->
    <transition name="preview" mode="out-in">
      <div v-if="files.length && previewUrl" class="preview" :key="previewUrl">
        <img :src="previewUrl" :alt="previewName" :title="previewName" />
      </div>
    </transition>
    <div class="thumbnail">
      <TransitionGroup name="fade" tag="ul">
        <li
          @mouseenter="showPreview"
          v-for="(file, index) in files"
          :key="file.name"
          :title="file.name"
          :style="{ '--delay': index * 0.1 + 's' }"
        >
          <img :src="file.url" :alt="file.name" />
        </li>
      </TransitionGroup>
    </div>
    <p v-if="errerMessage">{{ errerMessage }}</p>
  </main>
</template>

<style scoped>
h1 {
  text-align: center;
  margin-bottom: 10vh;
}
main {
  display: flex;
  width: 90%;
  margin: 0 auto;
}

/* workproduct内のファイルをサムネイル表示 */
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
.thumbnail {
  display: block;
}
.thumbnail img {
  width: 80%;
}

/* サムネイル画像のプレビュー表示 */
.preview {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 50%;
}
.preview img {
  width: 40vw;
}

.preview-enter-from {
  opacity: 0;
}
.preview-enter-to {
  opacity: 1;
}
.preview-enter-active {
  transition: all 0.5s ease;
}

.fade-enter-from {
  opacity: 0;
  transform: translateX(50px);
}
.fade-enter-to {
  opacity: 2;
  transform: translateX(0);
}
.fade-enter-active {
  transition: all 1s ease;
  transition-delay: var(--delay);
}
</style>
