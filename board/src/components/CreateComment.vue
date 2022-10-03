<template>
  <!-- 新增文章區域 -->
  <div class="middle center">
    <button
      v-if="user.check_name !== user.name"
      type="button"
      class="btn btn-dark center"
      disabled="disabled"
    >
      登入後可留言
    </button>
    <button
      v-if="user.check_name == user.name"
      type="button"
      class="btn btn-dark center"
      data-bs-toggle="modal"
      data-bs-target="#createComment"
    >
      新增留言
    </button>
  </div>
  <!-- 新增文章跳出框 -->
  <form
    @submit.prevent="
      createcomment();
      Alter();
    "
    class="form center input-group mb-3 middle-button"
  >
    <div
      class="modal fade"
      id="createComment"
      tabindex="-1"
      aria-labelledby="createCommentModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createCommentlLabel">新增資料</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="delCacheData"
            ></button>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="comment.title"
              type="text"
              class="form-control"
              id="floatingCreateSubject"
              placeholder="主旨"
            />
            <label for="floatingCreateSubject">主旨</label>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="comment.content"
              type="text"
              class="form-control"
              id="floatingCreateComment"
              placeholder="留言"
            />
            <label for="floatingCreateComment">留言</label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="delCacheData"
            >
              關閉
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              data-bs-dismiss="modal"
            >
              新增留言
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</template>
<script>
import { inject, toRefs, onMounted } from "vue";

import User from "@/components/User";
import Comment from "@/components/Comment";
import AlterToast from "@/components/Toast";
export default {
  setup() {
    const state = inject("statedata");

    let { delCacheData } = User(state);
    let { createcomment } = Comment(state);
    let { Alter } = AlterToast(state);
    onMounted(() => {
      Alter;
    });
    return {
      ...toRefs(state),
      createcomment,
      delCacheData,
      Alter,
    };
  },
};
</script>
