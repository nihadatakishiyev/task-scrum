// Mocks all files ending in `.vue` showing them as plain Vue instances
declare module '*.vue' {
  import Vue from 'vue'
  export default Vue
}
declare module 'vue/types/vue' {
  import VueRouter, { Route } from 'vue-router'
  interface Vue {
    $router: VueRouter
  }
}
