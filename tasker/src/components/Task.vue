<template>
  <q-card class="q-ma-xs  cursor-pointer drag-item" flat bordered @click="clicked"
          :style="'border-radius: 5px; border-top: 5px solid ' + getSelectedLabelColor(parseInt(task.priority_id)) ">
    <!--<div :class="colorO(parseInt(task.priority_id))" style=" min-height: 10px; border-radius: 2px"></div>-->
    <q-card-section>
      <div>
        <span class="text-weight-bold">{{ task.name }}</span>
      </div>
      <div class="q-mt-md">
        <q-avatar  size="42px">
          <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
        </q-avatar>
        <q-btn dense round size="22px" flat icon="message" color="primary" class=" float-right">
          <q-badge color="primary" floating transparent>
            {{task.comments_count}}
          </q-badge>
        </q-btn>
      </div>
    </q-card-section>
  </q-card>
</template>

<script>
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
    }
  }
}
</script>
