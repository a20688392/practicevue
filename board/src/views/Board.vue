<template>
  <Header></Header>
  <Search></Search>
  <AlterToast></AlterToast>
  <CreateComment></CreateComment>
  <AllComment></AllComment>
</template>
<script>
import Header from "@/components/Header.vue";
import Search from "@/components/Search.vue";
import AlterToast from "@/components/AlterToast.vue";
import CreateComment from "@/components/CreateComment.vue";
import AllComment from "@/components/AllComment.vue";
import User from "@/components/User";
import Comment from "@/components/Comment";
import { reactive, toRefs, onMounted, provide } from "vue";

export default {
  name: "app",
  components: {
    Header,
    Search,
    CreateComment,
    AllComment,
    AlterToast,
  },
  setup() {
    const state = reactive({
      //items 所有文章
      items: [],
      //使用者資訊
      /**
       * name 使用者名
       * check_name 是為了在Header.vue確認改變名字
       * email 使用者信箱
       * password 暫存密碼，送出後銷毀
       * user_id 使用者ID
       */
      user: {
        name: "",
        check_name: "none",
        email: "",
        password: "",
        user_id: "",
      },
      /**
       * 新增文章會使用到
       * content、title、user_id
       * 編輯文章會使用到
       *
       */
      comment: {
        comment_id: "",
        title: "",
        content: "",
        user_id: "",
      },
      cache: {
        id: "",
        title:"",
        content: "",
        status: false,
      },
      search: {
        first_time: "",
        last_time: "",
        search_content: "",
      },
      result: {
        event: "",
        status: "",
        content: "",
      },
    });
    provide("statedata", state);

    let { findUser } = User(state);

    let { getItems } = Comment(state);

    onMounted(() => {
      findUser();
      getItems();
      console.log("mounted!");
    });

    return {
      ...toRefs(state),
    };
  },
};
</script>
<style>
@import "@/css/index.css";
</style>
