<template>
  <!-- <button
    type="button"
    class="btn btn-primary"
    id="liveToastBtn"
    v-on:click="Alter"
  >
    Show live toast
  </button> -->
  <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div
      id="liveToast"
      class="toast"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
    >
      <!-- 修改失敗 -->
      <div class="toast-header toast-error" v-if="result.status == 'error'">
        <strong class="me-auto">{{result.event}}</strong>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="toast"
          aria-label="Close"
        ></button>
      </div>
      <!-- 修改成功 -->
      <div class="toast-header toast-success" v-if="result.status == 'success'">
        <strong class="me-auto">{{result.event}}</strong>

        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="toast"
          aria-label="Close"
        ></button>
      </div>
      <div class="toast-header toast-cancel" v-if="result.status == 'cancel'">
        <strong class="me-auto">{{result.event}}</strong>

        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="toast"
          aria-label="Close"
        ></button>
      </div>
      <div class="toast-body">{{ result.content }}</div>
    </div>
  </div>
</template>
<script>
import AlterToast from "@/components/Toast";
import { inject, toRefs, onMounted } from "vue";
export default {
  setup() {
    const state = inject("statedata");
    let { Alter } = AlterToast(state);
    onMounted(() => {
      Alter;
    });
    return {
      ...toRefs(state),
      Alter,
    };
  },
};
</script>
