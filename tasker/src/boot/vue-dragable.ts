import VueDraggable from 'vue-draggable'
import { boot } from 'quasar/wrappers'

export default boot(({ Vue }) => {
  Vue.use(VueDraggable)
})
