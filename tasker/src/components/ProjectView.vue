<template xmlns:v-drag-and-drop="http://www.w3.org/1999/xhtml">
  <div>
    <ProjectNav :project="currentProject" :user="user"/>
    <q-scroll-area
      horizontal
      style="height: 500px; width: 100%"
      visible
    >
      <div class="drag-container row no-wrap" v-drag-and-drop:options="options">
        <div class="col " v-for="(group, index) in groups" :key="index" >
          <q-card class="q-ma-md" flat >
            <div class="text-center text-weight-bold text-h5 q-pt-sm">
              <span>{{group.name}}</span>
            </div>
            <div class="q-mr-md q-ml-md q-pt-sm">
              <q-btn icon="add" class="full-width text-grey-14" unelevated label="Add task"
              @click="taskd = !taskd; selected= group.id"></q-btn>
            </div>
            <q-card-section >
              <q-scroll-area class="drag-inner-list scroll" :data-id="group.id" style="height: 350px; width: 380px" v-if="tasks">
                <Task class="q-ma-xs  cursor-pointer drag-item"
                        v-for="(item, index) in filteredItems(group.id)"  :key="index"
                        :data-id="item.id" :task="item" v-on:openTask="selectMTask"
              />
              </q-scroll-area>
            </q-card-section>
          </q-card>
        </div>
      </div>
    </q-scroll-area>
    <q-dialog v-model="taskd">
      <q-card style="min-width: 250px; width: 450px;">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Create Task</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-form @submit.prevent="submitTask">
          <q-input outlined v-model="task.name" label="Name" required/>
          <q-input
            required
            v-model="task.description"
            outlined
            class="q-pt-sm"
            label="Description"
            type="textarea"
          ></q-input>

          <q-select
            required
            outlined
            class="q-pt-sm"
            v-model="task.priority_id"
            option-value="id"
            option-label="name"
            emit-value
            map-options
            :options="priorityList"
            label="Choose Priority"
            options-selected-class="text-deep-orange"
          >
            <template v-slot:option="scope">
              <q-item
                v-bind="scope.itemProps"
                v-on="scope.itemEvents"
                :class="'bg-' + scope.opt.color"
              >
                <q-item-section>
                  <q-item-label class="text-white text-weight-bold" v-html="scope.opt.name" />
                </q-item-section>
              </q-item>
            </template>
          </q-select>
            <q-select
              filled
              class="q-mt-sm q-mb-sm"
              hide-dropdown-icon
              :option-value="(item) => item === null || item === undefined? '' : parseInt(item.user_id)"
              :option-label="(item) => item === null || item === undefined? '' : item.user.name"
              v-model="task.assigned_to_id"
              emit-value
              map-options
              use-input
              fill-input
              label="Search for assignable user."
              input-debounce="0"
              :options="mmemmbers"
              clearable
              @filter="filterFn"
              @filter-abort="abortFilterFn"
              hint="Mininum 2 characters to trigger search"
            >
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    No results
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          <q-input outlined v-model="task.deadline" label="Optional Deadline" class="q-pt-sm" required
          >
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                  <q-date v-model="task.deadline" mask="YYYY-MM-DD HH:mm" />
                </q-popup-proxy>
              </q-icon>
            </template>

            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                  <q-time v-model="task.deadline" mask="YYYY-MM-DD HH:mm" format24h />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <q-btn label="Create Task" icon="add" class="full-width q-mt-md" color="primary"
          type="submit"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <TaskView :openTask.sync="openTask" :selectedTask="selectedTask" v-on:taskDeleted="getCurrentProject"
    v-on:editProject="getCurrentProject"/>
  </div>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase,camelcase */
import ProjectNav from './ProjectNav'
import { LocalStorage } from 'quasar'
import Task from './Task'
import TaskView from './TaskView'
import { mapActions } from 'vuex'
const priorityList = LocalStorage.getItem('pl')
export default {
  name: 'SeconCompose',
  components: { TaskView, Task, ProjectNav },
  data () {
    const updateItemsWithNewGroupId = this.updateItemsWithNewGroupId
    return {
      currentID: '',
      currentProject: [],
      openTask: {
        bol: false
      },
      mmemmbers: [],
      selectedTask: null,
      taskd: false,
      selected: '',
      priorityList: priorityList,
      task: {
        name: '',
        assigned_to_id: null,
        owner_id: LocalStorage.getItem('user').id,
        label: 'Programming',
        is_completed: 0,
        project_id: this.currentID,
        group_id: '',
        description: '',
        deadline: '',
        priority_id: 1
      },
      user: '',
      groups: LocalStorage.has('gs') ? LocalStorage.getItem('gs') : [],
      tasks: [],
      options: {
        dropzoneSelector: '.drag-inner-list',
        draggableSelector: '.drag-item',
        onDrop (e) {
          const targetGroupId = parseInt(e.droptarget.dataset.id)
          console.log(targetGroupId)
          const itemIds = e.items.map(item => parseInt(item.dataset.id))
          updateItemsWithNewGroupId(itemIds, targetGroupId)
        }
      }
    }
  },
  computed: {
    filteredItems () {
      return group_id => this.tasks.filter(item => parseInt(item.group_id) === group_id)
    }
  },
  methods: {
    ...mapActions('projects', ['getProject']),
    ...mapActions('tasks', ['createTask', 'updateTask']),
    submitTask () {
      this.task.group_id = this.selected
      this.task.project_id = this.currentID
      console.log(this.task)
      this.createTask(this.task).then(response => {
        this.getCurrentProject()
        this.taskd = false
      }).catch(error => {
        this.taskd = false
        console.log(error)
      })
    },
    filterFn (val, update, abort) {
      if (val.length < 2) {
        abort()
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.mmemmbers.filter(item => item.user.name.includes(needle))
      })
    },
    abortFilterFn (val) {
      console.log(val)
    },
    selectMTask (task) {
      this.selectedTask = task
      this.openTask.bol = true
    },
    updateItemsWithNewGroupId (itemsIds, groupId) {
      this.tasks
        .filter(item => itemsIds.indexOf(item.id) >= 0)
        .forEach(item => {
          item.group_id = groupId
          console.log(item)
          this.updateTask(item).then(response => {
            console.log(response)
          }).catch(error => {
            console.log(error)
          })
        })
    },
    getCurrentProject () {
      this.$q.loading.show()
      this.getProject(this.currentID).then(response => {
        this.$q.loading.hide()
        this.$root.$emit('updatenots')
        this.currentProject = response.data[0]
        console.log(this.currentProject)
        this.mmemmbers = response.data[0].ups.filter(val => parseInt(val.accept_status) === 1)
        this.tasks = response.data[0].tasks.sort( function (a, b) {
          return b.created_at < a.created_at ? -1 : 1
        })
      }).catch(error => {
        this.$q.loading.hide()
        console.log(error)
      })
    }
  },
  created () {
    this.currentID = this.$route.params.projectID
    this.user = LocalStorage.getItem('user')
    this.getCurrentProject()
    this.$root.$on('commentMade', () => { this.getCurrentProject() })
  },
  beforeDestroy () {
    this.$root.$off('commentMade', () => { this.getCurrentProject() })
  }
}
</script>
