<template>
  <div>
    <q-dialog v-model="openAdd.bool">
      <q-card :style="'min-width: 250px; width: 650px; background-color: ' + ($q.dark.isActive ? 'dark' :' #eef2f3')">
        <q-card-section class="row  q-pb-none text-center ">
          <div class="text-h6 text-center cursor-pointer" >
           Add User
          </div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>
        <q-card-section>
          <q-select
            filled
            hide-dropdown-icon
            option-value="id"
            option-label="name"
            display-value
            v-model="model"
            use-input
            fill-input
            input-debounce="0"
            :options="options"
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
          <q-btn icon="add" class="full-width q-mt-md" color="green" v-if="model" @click="addMemmber2" label="Add"></q-btn>
        </q-card-section>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */

import { mapActions } from 'vuex'
export default {
  name: 'AddUser',
  props: ['openAdd', 'project'],
  data () {
    return {
      permission: {
        user_id: 1,
        project_id: this.project.id,
        accept_status: 0,
        permission_type_id: 1
      },
      model: null,
      options: Object.freeze(this.options)
    }
  },
  methods: {
    ...mapActions('memmbers', ['searchMemmber', 'addMemmber']),
    addMemmber2 () {
      if (this.model) {
        console.log(this.model)
        this.permission.user_id = this.model.id
        this.permission.project_id = this.project.id
        this.addMemmber(this.permission).then(response => {
          this.openAdd.bool = false
          this.$emit('userAdd')
          this.$root.$emit('commentMade')
          console.log(response)
        }).catch(error => {
          this.openAdd.bool = false
          console.log(error)
        })
      }
    },
    filterFn (val, update, abort) {
      if (val.length < 2) {
        abort()
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.searchMemmber(needle).then(response => {
          this.options = response.data
          console.log(this.options)
        }).catch(error => {
          abort(error)
          console.log(error)
        })
      })
    },
    abortFilterFn (val) {
      console.log(val)
    }
  }
}
</script>
