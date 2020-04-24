<template>
  <div>
  <q-dialog v-model="openTask.bol">
    <q-card :style="'min-width: 250px; width: 650px; background-color: ' + ($q.dark.isActive ? 'dark' :' #eef2f3')">
      <q-card-section class="row  q-pb-none text-center ">
        <div class="text-h6 text-center cursor-pointer" v-if="selectedTask !==null">
          {{selectedTask.name}}
          <q-icon color="primary" name="edit"  v-if="isEdit"/>
          <q-popup-edit buttons v-model="selectedTask.name" title="Edit the Name" v-if="isEdit">
            <q-input v-model="selectedTask.name" dense autofocus />
          </q-popup-edit>
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section v-if="selectedTask !==null">
        <q-list bordered :class="$q.dark.isActive ? 'bg-dark' :' bg-white' ">
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

            <q-item-section><span class="text-weight-bold cursor-pointer">{{selectedTask.description}}
                            <q-icon color="primary" name="edit"  v-if="isEdit" size="2em"/>

              <q-popup-edit buttons v-model="selectedTask.description" title="Edit the Description" v-if="isEdit">
                <q-input v-model="selectedTask.description" dense autofocus counter />
              </q-popup-edit>
            </span></q-item-section>
          </q-item>
          <q-item >
            <q-item-section avatar>
              <q-icon color="primary" name="label" />
            </q-item-section>

            <q-item-section>
              <q-btn unelevated class="block" icon="edit" :label="getSelectedLabel()" :color="getSelectedLabelColor()" v-if="isEdit">
              </q-btn>
              <q-btn unelevated class="block" :label="getSelectedLabel()" :color="getSelectedLabelColor()"  v-else></q-btn>
              <q-popup-edit buttons v-model="selectedTask.priority_id" title="Edit the Priority" v-if="isEdit">
                <q-select
                  required
                  outlined
                  class="q-pt-sm"
                  v-model="selectedTask.priority_id"
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
              </q-popup-edit>
            </q-item-section>
          </q-item>
          <q-item >
            <q-item-section avatar>
              <q-avatar  size="32px">
                <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
              </q-avatar>
            </q-item-section>

            <q-item-section><span class="text-weight-bold">{{selectedTask.assigned_to.name}}</span></q-item-section>
          </q-item>
          <q-item >
            <q-item-section avatar>
              <q-icon color="primary" name="timelapse" />
            </q-item-section>

            <q-item-section><span class="text-weight-bold">{{selectedTask.deadline}}
              &nbsp;<q-icon color="primary" name="edit" size="2em" v-if="isEdit" class="cursor-pointer"/>
               <q-popup-edit buttons v-model="selectedTask.deadline" title="Edit the Deadline" v-if="isEdit">
                <q-input outlined v-model="selectedTask.deadline" label="Optional Deadline" class="q-pt-sm" required
                >
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy  transition-show="scale" transition-hide="scale">
                  <q-date v-model="selectedTask.deadline" mask="YYYY-MM-DD HH:mm" />
                </q-popup-proxy>
              </q-icon>
            </template>

            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy  buttons transition-show="scale" transition-hide="scale">
                  <q-time v-model="selectedTask.deadline" mask="YYYY-MM-DD HH:mm" format24h />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
              </q-popup-edit>
            </span></q-item-section>

          </q-item>
        </q-list>
        <q-btn class="full-width q-mt-sm" icon="edit" label="Edit Task" color="green" flat @click="isEdit = !isEdit" v-if="!isEdit"></q-btn>
        <q-btn class="full-width q-mt-sm"
               icon="save" label="Save Changes" color="green" flat  @click="updateTask2" v-if="isEdit"></q-btn>
        <q-btn class="full-width q-mt-sm" icon="delete" label="Delete Task" color="red" flat
               @click="confirmDelete = !confirmDelete"
        ></q-btn>
      </q-card-section>
      <CommentView :task="selectedTask"/>
    </q-card>
  </q-dialog>
    <q-dialog v-model="confirmDelete" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="delete" flat color="white" text-color="red" />
          <span class="q-ml-sm">Do you agree to delete this task?</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancel" v-close-popup />
          <q-btn flat label="Yes" color="red" v-close-popup @click="deleteTask2" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */
import { mapActions } from 'vuex'
import CommentView from './ComentView'
export default {
  name: 'TaskView',
  components: { CommentView },
  props: ['openTask', 'selectedTask'],
  data () {
    return {
      confirmDelete: false,
      isEdit: false,
      mtask: this.selectedTask,
      op: this.openTask,
      groups: this.$q.localStorage.getItem('gs'),
      priorityList: this.$q.localStorage.getItem('pl')
    }
  },
  methods: {
    ...mapActions('tasks', ['updateTask', 'deleteTask']),
    deleteTask2 () {
      this.$q.loading.show()
      this.deleteTask(this.selectedTask).then(response => {
        this.$emit('taskDeleted')
        this.confirmDelete = false
        this.openTask.bol = false
        console.log(response)
      }).catch(error => {
        this.confirmDelete = false
        this.openTask.bol = false
        console.log(error)
      })
    },
    updateTask2 () {
      this.$q.loading.show()
      this.isEdit = false
      this.updateTask(this.selectedTask).then(response => {
        this.$q.loading.hide()
        console.log(response)
      }).catch(error => {
        this.$q.loading.hide()
        console.log(error)
      })
    },
    getSelectedTaskGroup () {
      return this.groups.filter(item => item.id === parseInt(this.selectedTask.group_id))[0].name
    },
    getSelectedLabel () {
      return this.priorityList.filter(item => item.id === parseInt(this.selectedTask.priority_id))[0].name
    },
    getSelectedLabelColor () {
      return this.priorityList.filter(item => item.id === parseInt(this.selectedTask.priority_id))[0].color
    }
  }
}
</script>
