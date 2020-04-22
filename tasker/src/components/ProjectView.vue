<template>
  <div>
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
              <q-card class="q-ma-xs  cursor-pointer drag-item"  v-for="(item, index) in filteredItems(group.id)"  :key="index"
                      :data-id="item.id" flat bordered @click="selectedTask = item; openTask = !openTask">
                <div :class="colorO(item.priority_id)" style="max-width: 50px; min-height: 10px; border-radius: 5px"></div>
                <q-card-section>
                  {{ item.name }}
                  <q-list>
                    <q-item >
                      <q-item-section side>
                        <q-avatar  size="32px">
                          <img src="https://cdn.quasar.dev/img/avatar.png" />
                        </q-avatar>
                      </q-item-section>
                      <q-item-section>
                      </q-item-section>
                      <q-item-section side>
                        <q-btn dense round flat icon="message">
                          <q-badge color="green" floating transparent>
                            4
                          </q-badge>
                        </q-btn>
                      </q-item-section>
                    </q-item>
                  </q-list>
                </q-card-section>
              </q-card>
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
          <q-input outlined v-model="task.name" label="Name" />
          <q-input
            v-model="task.description"
            outlined
            class="q-pt-sm"
            label="Description"
            type="textarea"
          ></q-input>

          <q-select
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

          <q-input outlined v-model="task.deadline" label="Optional Deadline" class="q-pt-sm"
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
          @click="addTask"></q-btn>
        </q-card-section>
      </q-card>
    </q-dialog>
    <q-dialog v-model="openTask">
      <q-card style="min-width: 650px; background-color: #eef2f3">
        <q-card-section class="row items-center q-pb-none text-center">
          <div class="text-h6 " v-if="selectedTask !==null">{{selectedTask.name}}</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-card-section v-if="selectedTask !==null">
          <q-list bordered class="bg-white">
            <q-item >
              <q-item-section avatar>
                <q-icon color="primary" name="list" />
              </q-item-section>

              <q-item-section><span class="text-weight-bold">{{getSelectedTaskGroup()}}</span></q-item-section>
            </q-item>
            <q-item >
              <q-item-section avatar>
                <q-icon color="primary" name="description" />
              </q-item-section>

              <q-item-section><span class="text-weight-bold">{{selectedTask.description}}</span></q-item-section>
            </q-item>
            <q-item >
              <q-item-section avatar>
                <q-icon color="primary" name="label" />
              </q-item-section>

              <q-item-section><q-btn unelevated class="block" :label="getSelectedLabel()" :color="getSelectedLabelColor()" ></q-btn></q-item-section>
            </q-item>
            <q-item >
              <q-item-section avatar>
                <q-icon color="primary" name="assignment" />
              </q-item-section>

              <q-item-section><span class="text-weight-bold">Ogtay Huseynov</span></q-item-section>
            </q-item>
            <q-item >
              <q-item-section avatar>
                <q-icon color="primary" name="timelapse" />
              </q-item-section>

              <q-item-section><span class="text-weight-bold">Nov 16, 2018 at 4:29 PM</span></q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
        <q-card-section>
          <q-input filled bottom-slots v-model="comment.text" label="Make a Comment" counter maxlength="250" >
            <template v-slot:append>
              <q-btn round dense flat icon="send" />
            </template>
          </q-input>
        </q-card-section>
        <q-card-section>
          <div class="text-center">
            <span class="text-weight-bold text-grey-14">Comments</span>
          </div>
          <div class="q-mt-sm-lg">
              <div v-for="(item, index) in items" :key="index" class="q-mt-lg">
                <span class="text-weight-bold text-grey-14"> Ogtay Huseynov</span> &nbsp;&nbsp;
                <span class="text-weight-bold text-grey-14">Nov 16, 2018 at 4:29 PM</span>
                <q-card flat>
                  <q-card-section>
                      ASDASDASDASDASDASDASDASDASDASD ASDASDASDAS ASDASDASDasdasdsa asdasdasdsd
                  </q-card-section>
                </q-card>
              </div>
          </div>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */
const priorityList = [
  { id: 1, name: 'Crucial', color: 'red' },
  { id: 2, name: 'Optional', color: 'green' },
  { id: 3, name: 'Desirible', color: 'yellow' },
  { id: 4, name: 'Important', color: 'orange' },
  { id: 5, name: 'Extra', color: 'blue' }
]
export default {
  name: 'SeconCompose',
  data () {
    const updateItemsWithNewGroupId = this.updateItemsWithNewGroupId
    return {
      comment: {
        text: ''
      },
      openTask: false,
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
      groups: [
        { id: 1, name: 'To Do' },
        { id: 2, name: 'In Progress' },
        { id: 3, name: 'Done' }
      ],
      items: [{
        id: 1,
        name: 'ASD',
        groupId: 1,
        description: '123123123',
        deadline: '',
        priority_id: 1
      },
      {
        id: 2,
        name: 'ASDASDASDAS',
        groupId: 2,
        description: 'ASDASDASDA',
        deadline: '',
        priority_id: 2
      },
      {
        id: 3,
        name: '123123123',
        groupId: 3,
        description: 'ASDSAD',
        deadline: '',
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
    colorO (id) {
      return 'bg-' + this.priorityList.filter(item => item.id === id)[0].color + ' q-ma-xs q-ml-md'
    },
    getSelectedTaskGroup () {
      return this.groups.filter(item => item.id === this.selectedTask.groupId)[0].name
    },
    getSelectedLabel () {
      return this.priorityList.filter(item => item.id === this.selectedTask.id)[0].name
    },
    getSelectedLabelColor () {
      return this.priorityList.filter(item => item.id === this.selectedTask.id)[0].color
    },
    addTask () {
      this.task.groupId = this.selected
      this.task.id = this.items.length + 1
      console.log(this.task)
      this.items.unshift({ id: this.task.id, name: this.task.name, groupId: this.selected, priority_id: this.task.priority_id })
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
