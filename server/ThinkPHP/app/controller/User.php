<?php

namespace app\controller;

use think\Request;

class User
{
    public function login(Request $request)
    {
        // 用户名
        $userName = $request->post('userName');
        // 密码
        $password = $request->post('password');

        // 用户名、密码不能为空
        if (empty($userName) || empty($password)) {
            return json([
                'code' => 1,
                'msg' => '用户名或密码不能为空',
                'data' => null
            ]);
        }

        // 验证用户名、密码
        if ($userName != 'admin' || $password != 'admin') {
            return json([
                'code' => 1,
                'msg' => '用户名或密码错误',
                'data' => null
            ]);
        }

        // 生成token
        $token = bin2hex(random_bytes(32));

        // 验证通过
        return json([
            'code' => 0,
            'msg' => '登录成功',
            'data' => [
                'userName' => $userName,
                'token' => $token,
            ]
        ]);
    }
}