import { store } from 'quasar/wrappers'
import Vuex from 'vuex'

// import example from './module-example'
// import exampleState from './module-example/state'
import auth from './auth'
import tasks from './tasks'
import memmbers from './memmbers'
import comments from './comments'
import users from './users'
import projects from './projects'

/*
 * If not building with SSR mode, you can
 * directly export the Store instantiation
 */

export interface StoreInterface {
  // Define your own store structure, using submodules if needed
  // example: typeof exampleState;
  example: unknown;
}

export default store(function ({ Vue }) {
  Vue.use(Vuex)

  const Store = new Vuex.Store({
    modules: {
      // example
      auth,
      comments,
      users,
      projects,
      tasks,
      memmbers
    },

    // enable strict mode (adds overhead!)
    // for dev mode only
    strict: !!process.env.DEV
  })

  return Store
})
