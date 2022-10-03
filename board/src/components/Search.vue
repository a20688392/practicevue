<template>
  <!-- 查詢關鍵字 -->
  
  <form @submit.prevent="searchcomment();Alter()">
    <div class="search">
      <div class="search-input">
        <div class="search-text">
          起
          <input
            type="datetime-local"
            class="btn btn-outline-secondary search-btn"
            v-model="search.first_time"
          />
          <div>~</div>
          <div>迄</div>
          <input
            type="datetime-local"
            class="btn btn-outline-secondary search-btn"
            v-model="search.last_time"
          />
        </div>
        <input
          type="text"
          class="form-control"
          placeholder="欲查詢的關鍵字"
          v-model="search.search_content"
        />
      </div>
      <div class="search-submit">
        <input
          class="middle-submit middle-div btn btn-dark"
          type="submit"
          value="查詢關鍵字"
        />
      </div>
    </div>
  </form>
</template>
<script>
import { inject, toRefs,onMounted } from "vue";
import Comment from "@/components/Comment";
import AlterToast from "@/components/Toast";
export default {
  setup() {
    const state = inject("statedata");
    let { searchcomment } = Comment(state);
    let { Alter } = AlterToast(state);
    onMounted(() => {
      Alter;
    });

    return {
      ...toRefs(state),
      searchcomment,
      Alter,
    };
  },
};
</script>
