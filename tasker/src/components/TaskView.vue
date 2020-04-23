<template>
  <div>
  <q-dialog v-model="openTask.bol">
    <q-card style="min-width: 250px; width: 650px; background-color: #eef2f3">
      <q-card-section class="row  q-pb-none text-center ">
        <div class="text-h6 text-center" v-if="selectedTask !==null">{{selectedTask.name}}</div>
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

            <q-item-section><span class="text-weight-bold">{{selectedTask.deadline}}</span></q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
        <CommentView :task="selectedTask"/>
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
      op: this.openTask,
      groups: this.$q.localStorage.getItem('gs'),
      priorityList: this.$q.localStorage.getItem('pl')
    }
  },
  methods: {
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
