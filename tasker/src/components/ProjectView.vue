<template xmlns:v-drag-and-drop="http://www.w3.org/1999/xhtml">
  <div>
    <ProjectNav/>
      <div class="drag-container row" v-drag-and-drop:options="options">
        <div class="col" v-for="group in groups" :key="group.id" >
          <q-card class="q-ma-md" flat >
            <div class="text-center text-weight-bold text-h5 q-pt-sm">
              <span>{{group.name}}</span>
            </div>
            <div class="q-mr-md q-ml-md q-pt-sm">
              <q-btn icon="add" class="full-width text-grey-14" unelevated label="Add task"
              @click="taskd = !taskd; selected= group.id"></q-btn>
            </div>
            <q-card-section >
              <q-scroll-area class="drag-inner-list scroll" :data-id="group.id" style="height: 400px;" >
                <Task class="q-ma-xs  cursor-pointer drag-item"
                      v-for="(item, index) in filteredItems(group.id)"  :key="index"
                      :data-id="item.id" :task="item" flat bordered v-on:openTask="selectMTask"
                />
              </q-scroll-area>
            </q-card-section>
          </q-card>
        </div>
      </div>
    <q-dialog v-model="taskd">
      <q-card style="min-width: 450px">
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
          <q-btn label="Create Project" icon="add" class="full-width q-mt-md" color="primary"
          @click="addTask" type submit></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <TaskView :openTask.sync="openTask" :selectedTask="selectedTask"/>
  </div>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */
import ProjectNav from './ProjectNav'
import { LocalStorage } from 'quasar'
import Task from './Task'
import TaskView from './TaskView'

const priorityList = LocalStorage.getItem('pl')
export default {
  name: 'SeconCompose',
  components: { TaskView, Task, ProjectNav },
  data () {
    const updateItemsWithNewGroupId = this.updateItemsWithNewGroupId
    return {
      openTask: {
        bol: false
      },
      selectedTask: null,
      taskd: false,
      selected: '',
      priorityList: priorityList,
      task: {
        id: '',
        name: '',
        groupId: '',
        description: '',
        deadline: '',
        priority_id: 1
      },
      groups: LocalStorage.getItem('gs'),
      items: [{
        id: 1,
        name: 'ASD',
        groupId: 1,
        description: '123123123',
        deadline: 'Nov 16, 2018 at 4:29 PM',
        priority_id: 1
      },
      {
        id: 2,
        name: 'ASDASDASDAS',
        groupId: 2,
        description: 'ASDASDASDA',
        deadline: 'Nov 16, 2018 at 4:29 PM',
        priority_id: 2
      },
      {
        id: 3,
        name: '123123123',
        groupId: 3,
        description: 'ASDSAD',
        deadline: 'Nov 16, 2018 at 4:29 PM',
        priority_id: 2
      }],
      options: {
        dropzoneSelector: '.drag-inner-list',
        draggableSelector: '.drag-item',
        onDrop (e) {
          const targetGroupId = parseInt(e.droptarget.dataset.id)
          const itemIds = e.items.map(item => parseInt(item.dataset.id))
          updateItemsWithNewGroupId(itemIds, targetGroupId)
        }
      }
    }
  },
  computed: {
    filteredItems () {
      return groupId => this.items.filter(item => item.groupId === groupId)
    }
  },
  methods: {
    selectMTask (task) {
      this.selectedTask = task
      this.openTask.bol = true
    },
    addTask () {
      this.task.groupId = this.selected
      this.task.id = this.items.length + 1
      console.log(this.task)
      this.items.unshift({
        id: this.task.id,
        name: this.task.name,
        groupId: this.selected,
        priority_id: this.task.priority_id,
        description: this.task.description,
        deadline: this.task.deadline
      })
      this.taskd = !this.taskd
    },
    updateItemsWithNewGroupId (itemsIds, groupId) {
      this.items
        .filter(item => itemsIds.indexOf(item.id) >= 0)
        .forEach(item => {
          item.groupId = groupId
        })
    }
  }
}
</script>
