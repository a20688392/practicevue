import axios from "axios";
import Storage from "@/components/Storage";

export default function importComment(state) {
  let { localGet } = Storage();
  //搜尋關鍵字
  function searchcomment() {
    const options = {
      method: "post",
      headers: { "content-type": "multipart/form-data" },
      data: {
        first_time: state.search.first_time,
        last_time: state.search.last_time,
        search_content: state.search.search_content,
      },
      url: "http://localhost/practicevue/board-api/src/function/comment/searchComment.php",
    };
    axios(options)
      .then((res) => {
        console.log("searchcomment ok");
        console.log(res);
        state.items.statement = {};
        state.items = res.data;
        state.result.event = res.data.event;
        state.result.status = res.data.status;
        state.result.content = res.data.content;
      })
      .catch((error) => {
        console.log("no");
        console.log(error);
      });
  }
  // 抓到要編輯的留言ID
  function edit(cache) {
    state.cache.id = cache.id;
    state.cache.title = cache.title;
    state.cache.content = cache.content;
    console.log("edit catchid ok " + state.cache);
  }
  // 決定要不要編輯
  function checkedit(status) {
    if (status) {
      console.log("確定編輯");
      const options = {
        method: "POST",
        headers: { "content-type": "multipart/form-data" },
        withCredentials: true,
        data: {
          comment_id: state.cache.id,
          comment_title: state.cache.title,
          comment_content: state.cache.content,
          token: localGet(),
        },
        url: "http://localhost/practicevue/board-api/src/function/comment/editComment.php",
      };
      axios(options)
        .then((res) => {
          console.log("確定編輯 ok");
          console.log(res);
          state.result.event = res.data.event;
          state.result.status = res.data.status;
          state.result.content = res.data.content;
          state.cache = {};
          getItems();
        })
        .catch((error) => {
          console.log("編輯 no");
          console.log(error);
        });
    } else {
      console.log("取消編輯 no");
      state.cache = {};
      state.result.status = "cancel";
      state.result.content = "取消編輯";
      getItems();
    }
  }
  //抓到所有留言
  function getItems() {
    const options = {
      method: "GET",
      headers: { "content-type": "multipart/form-data" },
      url: "http://localhost/practicevue/board-api/src/function/comment/getAll.php",
    };
    axios(options).then((res) => {
      console.log(res);
      state.items = res.data;
    });
  }
  //創建留言
  function createcomment() {
    const options = {
      method: "POST",
      headers: { "content-type": "multipart/form-data" },
      withCredentials: true,
      data: {
        title: state.comment.title,
        content: state.comment.content,
        user_id: state.user.user_id,
        token: localGet(),
      },
      url: "http://localhost/practicevue/board-api/src/function/comment/createComment.php",
    };
    axios(options)
      .then((res) => {
        console.log("create ok");
        console.log(res);
        delCommentCacheData();
        state.result.event = res.data.event;
        state.result.status = res.data.status;
        state.result.content = res.data.content;
        getItems();
      })
      .catch((error) => {
        console.log("create error");
        console.log(error);
      });
  }
  //刪除留言
  function delcomment(comment_id) {
    var ans = confirm("確認要刪除這筆資料嗎?");
    if (ans == true) {
      const options = {
        method: "POST",
        headers: { "content-type": "multipart/form-data" },
        withCredentials: true,
        data: {
          comment_id: comment_id,
          token: localGet(),
        },
        url: "http://localhost/practicevue/board-api/src/function/comment/delComment.php",
      };

      axios(options)
        .then((res) => {
          console.log("刪除留言 ok");
          console.log(res);
          state.result.event = res.data.event;
          state.result.status = res.data.status;
          state.result.content = res.data.content;
          getItems();
        })
        .catch((error) => {
          console.log("刪除留言 no");
          console.log(error);
        });
    } else {
      state.result.event = "刪除訊息";
      state.result.status = "cancel";
      state.result.content = "取消刪除";
    }
  }
  function delCommentCacheData() {
    state.comment.comment_id = "";
    state.comment.content = "";
    state.comment.title = "";
    state.comment.user_id = "";
  }
  return {
    // ...toRefs(state),
    getItems,
    delcomment,
    createcomment,
    edit,
    checkedit,
    searchcomment,
    delCommentCacheData,
    localGet,
  };
}
