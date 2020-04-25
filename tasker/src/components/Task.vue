<template>
  <q-card class="q-ma-xs  cursor-pointer drag-item" flat bordered @click="clicked"
          :style="'border-radius: 5px; border-top: 5px solid ' + getSelectedLabelColor(parseInt(task.priority_id)) ">
    <!--<div :class="colorO(parseInt(task.priority_id))" style=" min-height: 10px; border-radius: 2px"></div>-->
    <q-card-section>
      <div class="text-center">
        <span class="text-weight-bold text-h6">{{ task.name }}</span>
      </div>
      <div class="q-mt-md  q-pb-none">
        <q-badge color="orange" style="font-size: 16px">
          <q-icon name="timelapse"></q-icon> &nbsp;
          {{formatMDate(task.deadline)}}
        </q-badge>
        <q-badge  class="float-right q-mt-xs" style="font-size: 16px">
          {{task.comments_count}} &nbsp;
          <q-icon name="comment"></q-icon>
        </q-badge>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
  import {date} from 'quasar'
export default {
  name: 'Task',
  props: ['task'],
  data () {
    return {
      priorityList: this.$q.localStorage.getItem('pl')
    }
  },
  methods: {
    colorO (id) {
      return 'bg-' + this.priorityList.filter(item => item.id === id)[0].color + ' q-ma-xs q-ml-md'
    },
    clicked () {
      this.$emit('openTask', this.task)
    },
    getSelectedLabelColor (id) {
      return this.priorityList.filter(item => item.id === id)[0].color
    },
    formatMDate (timestamp) {
      return  date.formatDate(timestamp, 'MMM DD')
    }
  }
}
</script>
