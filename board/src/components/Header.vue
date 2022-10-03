<template>
  <!--顯示模組-->
  <header>
    <nav class="nav navbar-dark bg-dark nav-text justify-content-end">
      <div class="nav-right nav-item nav-mid">
        <button
          class="btn btn-primary header-btn"
          data-bs-toggle="modal"
          data-bs-target="#loginModal"
          aria-hidden="true"
          v-if="user.check_name !== user.name"
        >
          登入
        </button>
        <span class="login-name" v-if="user.check_name == user.name">
          {{ user.check_name }}
        </span>
        <button
          class="btn btn-primary header-btn"
          v-if="user.check_name == user.name"
          @click="logout"
        >
          登出
        </button>
        <button
          class="btn btn-primary"
          data-bs-toggle="modal"
          data-bs-target="#registerModal"
          aria-hidden="true"
          v-if="user.check_name !== user.name"
        >
          註冊
        </button>
      </div>
    </nav>
  </header>
  <!-- Login Modal -->
  <div
    class="modal fade"
    id="loginModal"
    tabindex="-1"
    aria-labelledby="loginModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          @submit.prevent="
            login();
            Alter();
          "
        >
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">登入</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="delUserCacheData"
            ></button>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="user.name"
              type="text"
              class="form-control"
              id="floatingLoginAccount"
              placeholder="請輸入帳號"
            />
            <label for="floatingLoginAccount">請輸入帳號</label>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="user.password"
              type="password"
              class="form-control"
              id="floatingLoginPassword"
              placeholder="請輸入密碼"
            />
            <label for="floatingLoginPassword">請輸入密碼</label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="delUserCacheData"
            >
              關閉
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              data-bs-dismiss="modal"
            >
              確認
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- register -->
  <div
    class="modal fade"
    id="registerModal"
    tabindex="-1"
    aria-labelledby="registerModalLabel"
    aria-hidden="true"
  >
    <div class="modal-dialog">
      <div class="modal-content">
        <form
          @submit.prevent="
            register();
            Alter();
          "
        >
          <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">註冊</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
              @click="delUserCacheData"
            ></button>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="user.name"
              type="text"
              class="form-control"
              id="floatingInput"
              placeholder="請輸入帳號"
            />
            <label for="floatingInput">請輸入帳號</label>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="user.email"
              type="text"
              class="form-control"
              id="floatingRegisterEmail"
              placeholder="請輸入信箱"
            />
            <label for="floatingRegisterEmail">請輸入信箱</label>
          </div>
          <div class="form-floating card-margin">
            <input
              v-model="user.password"
              type="password"
              class="form-control"
              id="floatingRegisterPassword"
              placeholder="請輸入密碼"
            />
            <label for="floatingRegisterPassword">請輸入密碼</label>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
              @click="delUserCacheData"
            >
              關閉
            </button>
            <button
              type="submit"
              class="btn btn-primary"
              data-bs-dismiss="modal"
            >
              確認
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import { inject, toRefs, onMounted } from "vue";
import User from "@/components/User";
import AlterToast from "@/components/Toast";
export default {
  setup() {
    const state = inject("statedata");
    let { Alter } = AlterToast(state);
    onMounted(() => {
      Alter;
    });
    let { register, login, logout, delUserCacheData } = User(state);

    return {
      ...toRefs(state),
      register,
      login,
      logout,
      delUserCacheData,
      Alter,
    };
  },
};
</script>
