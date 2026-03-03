import axios from 'axios'
import qs from 'qs'
import { ElMessage } from 'element-plus'

// 创建 axios 实例
const instance = axios.create({
    baseURL:"http://121.40.100.92:8080",
    timeout: 10000, // 请求超时时间
    headers: { 'Content-Type': 'application/json' } // 默认 JSON 格式

})

// 请求拦截器
instance.interceptors.request.use(
    config => {

        // 数据序列化
        if (config.method === 'post' && config.data && config.headers['Content-Type'] === 'application/x-www-form-urlencoded') {
            config.data = qs.stringify(config.data)
        }
        return config
    },
    error => Promise.reject(error)
)

// 响应拦截器
instance.interceptors.response.use(
    response => {
        return response.data
    },
    error => {
        // 统一错误处理
        if (error.response) {
            // 服务器错误
            const status = error.response.status
            const message = error.response.data?.message || '请求失败'
            ElMessage.error(`错误 ${status}: ${message}`)
        } else if (error.request) {
            // 请求发出但无响应（网络问题、超时）
            ElMessage.error('网络连接失败，请检查网络')
        } else {
            // 其他错误
            ElMessage.error('请求配置错误')
        }
        return Promise.reject(error)
    }
)

export default instance