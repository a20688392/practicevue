<template>
  <!-- <button v-on:click="localSet()">
    storage
  </button>
  <button v-on:click="localGet()">
    Get
  </button> -->
  <div>
    <ul>
      <li class="card" v-for="(data, i) in items.statement" :key="i">
        <div class="card-id">{{ data.id }}{{ data.title }}</div><!--{{ data.id }}-->
        <div class="card-content">
          <div>
            <div v-if="data.id == cache.id">標題：</div>
            <input
            type="text"
            class="form-control"
            v-if="data.id == cache.id"
            v-model="cache.title"
          />
          </div>
          <div>
            <div>留言：</div>
            <label v-if="data.id !== cache.id">{{ data.content }}</label>
            <input
            type="text"
            class="form-control"
            v-if="data.id == cache.id"
            v-model="cache.content"
          />
          </div>
          
          <div class="card-margin">
            <div class="card-time">{{ data.created_at }}</div>
            <div class="card-time">{{ data.updated_at }}</div>
          </div>

          <div class="card-margin" v-if="user.user_id == data.user_id">
            <button
              v-if="data.id !== cache.id"
              @click="edit(data)"
              class="btn btn-primary"
            >
              編輯
            </button>
            <button
              v-if="data.id == cache.id"
              @click="
                checkedit(true);
                Alter();
              "
              class="btn btn-success"
            >
              完成
            </button>
            <button
              v-if="data.id == cache.id"
              @click="
                checkedit(false);
                Alter();
              "
              class="btn btn-secondary"
            >
              取消
            </button>
            <button
              v-if="data.id !== cache.id"
              @click="
                delcomment(data.id);
                Alter();
              "
              class="btn btn-danger"
            >
              刪除
            </button>
          </div>
        </div>
      </li>
    </ul>
  </div>

</template>
<script>
import { inject, toRefs, onMounted } from "vue";
import AlterToast from "@/components/Toast";
import Storage from "@/components/Storage";
import Comment from "@/components/Comment";
export default {
  setup() {
    const state = inject("statedata");
    let { Alter } = AlterToast(state);
    let { localSet,localGet } = Storage();
    let { delcomment, edit, checkedit } = Comment(state);
    onMounted(() => {
      Alter;
    });
    return {
      ...toRefs(state),
      delcomment,
      edit,
      checkedit,
      localGet,
      localSet,
      Alter,
    };
  },
};
</script>
