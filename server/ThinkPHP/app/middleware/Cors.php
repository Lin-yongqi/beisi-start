<?php
declare(strict_types=1);

namespace app\middleware;

use think\Request;
use think\Response;

class Cors
{
    /**
     * 处理请求
     *
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        // 允许的域名列表
        $allowedOrigins = [
            'http://localhost:5173',
            'http://www.demo.com',      // 前端域名
        ];

        $origin = $request->header('origin') ?: '';

        if (in_array($origin, $allowedOrigins)) {
            // 设置允许的域名
            header('Access-Control-Allow-Origin: ' . $origin);
            // 允许携带凭证
            header('Access-Control-Allow-Credentials: true');
            // 允许的请求方法
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            // 允许的请求头
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, Origin');
            // 预检请求缓存时间（秒）
            header('Access-Control-Max-Age: 86400');
        }

        // 如果是预检请求（OPTIONS），直接返回 204 响应
        if ($request->method(true) === 'OPTIONS') {
            return response()->code(204);
        }

        return $next($request);
    }
}