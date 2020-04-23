<template>
  <div>
  <q-dialog v-model="openTask.bol">
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

            <q-item-section><span class="text-weight-bold">{{selectedTask.deadline}}</span></q-item-section>
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
        <CommentView/>
      </q-card-section>
    </q-card>
  </q-dialog>
  </div>
</template>

<script>
import CommentView from './ComentView'
export default {
  name: 'TaskView',
  components: { CommentView },
  props: ['openTask', 'selectedTask'],
  data () {
    return {
      op: this.openTask,
      comment: {
        text: ''
      },
      groups: this.$q.localStorage.getItem('gs'),
      priorityList: this.$q.localStorage.getItem('pl')
    }
  },
  methods: {
    getSelectedTaskGroup () {
      return this.groups.filter(item => item.id === this.selectedTask.groupId)[0].name
    },
    getSelectedLabel () {
      return this.priorityList.filter(item => item.id === this.selectedTask.priority_id)[0].name
    },
    getSelectedLabelColor () {
      return this.priorityList.filter(item => item.id === this.selectedTask.priority_id)[0].color
    }
  },
  mounted () {
    console.log(this.selectedTask)
  }
}
</script>
