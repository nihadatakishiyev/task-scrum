import axios from 'axios'
import {route} from "quasar/wrappers";

// We create our own axios instance and set a custom base URL.
// Note that if we wouldn't set any config here we do not need
// a named export, as we could just `import axios from 'axios'`
const axiosInstance = axios.create({
  baseURL: 'http://api.yeddi.ml/api'
})

// for use inside Vue files through this.$axios

// Here we define a named export
// that we can later use inside .js files:
export default ({ router, store, Vue }) => {
  axiosInstance.interceptors.response.use(
    response => successHandler(response),
    error => errorHandler(error)
  )
  const errorHandler = (error) => {
    if(error.response.status === 301) {
      router.push('/')
      return Promise.reject({...error})

    }else if(error.response.status === 404) {
      router.push('/')
      return Promise.reject({...error})
    }else {
      return Promise.reject({...error})
    }
  }

  const successHandler = (response) => {
    return response
  }
  Vue.prototype.$axios = axiosInstance

}
