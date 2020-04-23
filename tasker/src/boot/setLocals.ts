import { LocalStorage } from 'quasar'
import { boot } from 'quasar/wrappers'

export default boot(({ Vue }) => {
  const priorityList = [
    { id: 1, name: 'Crucial', color: 'red' },
    { id: 2, name: 'Optional', color: 'green' },
    { id: 3, name: 'Desirible', color: 'yellow' },
    { id: 4, name: 'Important', color: 'orange' },
    { id: 5, name: 'Extra', color: 'blue' }
  ]
  const groups = [
    { id: 1, name: 'To Do' },
    { id: 2, name: 'In Progress' },
    { id: 3, name: 'Done' }
  ]
  LocalStorage.set('pl', priorityList)
  LocalStorage.set('gs', groups)
})
