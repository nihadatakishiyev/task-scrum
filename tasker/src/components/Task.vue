<template>
  <q-card class="q-ma-xs  cursor-pointer drag-item" flat bordered @click="clicked">
    <div :class="colorO(task.priority_id)" style="max-width: 50px; min-height: 10px; border-radius: 5px"></div>
    <q-card-section>
      {{ task.name }}
      <q-list>
        <q-item >
          <q-item-section side>
            <q-avatar  size="32px">
              <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
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
    }
  }
}
</script>
