<template>
  <div class="main">
    <div class="title">
      <h2>登录</h2>
    </div>
    <div class="form">
      <input type="text" placeholder="用户名" v-model="userName">
      <input type="password" placeholder="密码" v-model="password">
      <el-button class="login-btn" type="primary" :loading="isLoading" round @click="login">登录</el-button>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { ElMessage } from 'element-plus'
import request from '@/utils/http'

let userName = ref("");
let password = ref("");
let isLoading = ref(false);

// 登录
function login() {

  // 用户名或密码不能为空
  if (!userName.value.trim() || !password.value.trim()) {

    ElMessage({
      message: '用户名或密码不能为空',
      placement: "top",
      type: 'warning',
    })

    return;
  }

  // 禁用登录按钮
  isLoading.value = true;

  request.post('/user/login', {
    userName: userName.value,
    password: password.value
  })
    .then(res => {

      // 取消禁用登录按钮
      isLoading.value = false;

      // 登录成功
      if (res.code == 0) {
        ElMessage({
          message: "登录成功，欢迎 " + res.data.userName,
          placement: "top",
          type: 'success',
        })

        // 存储token
        localStorage.setItem('token', res.data.token);
        return;
      }

      // 登录失败
      ElMessage({
        message: res.msg,
        placement: "top",
        type: 'error',
      })

    })
    .catch(error => {
      // 取消禁用登录按钮
      isLoading.value = false;
      console.error('登录失败', error)
    })


}
</script>

<style scoped>
.main {
  width: 500px;
  height: 300px;
  background-color: white;
  border-radius: 30px;
}

.title {
  display: flex;
  justify-content: center;
}

.form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.form>input {
  width: 280px;
  height: 40px;
  border-radius: 25px;
  background-color: #F6F6F6;
  border: 0px;
  margin-bottom: 20px;
  padding-left: 20px;
  font-size: 16px;
}

.form>input:focus {
  outline: none;
}

.login-btn {
  font-weight: bold;
  border: 0px;
  width: 300px;
  border-radius: 25px;
  height: 40px;
}
</style>
