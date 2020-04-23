<template>
  <q-page class="q-ma-xl">
    <div class="row"><div class="col text-center">
      <span class="text-weight-medium text-h4 ">All Projects</span>
    </div></div>
    <div class="row q-col-gutter-y-m">
      <div class="col col-xs-12 col-sm-6 col-md-3">
        <q-card class="cursor-pointer q-ma-md" @click="icon = true" flat bordered>
          <q-card-section class="text-center">
            <span class="text-weight-medium text-h6">Create Project</span> <br/>
            <q-icon name="add" size="40px" class="text-grey-14"></q-icon>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-6 col-md-3" v-for="key in data" :key="key">
        <q-card class="cursor-pointer q-ma-md" flat bordered @click="sendMe(key)">
          <q-card-section class="text-center">
            <span class="text-weight-medium text-h6">{{key}}</span> <br/>
            <q-icon name="open_in_new" size="40px"></q-icon>
          </q-card-section>
        </q-card>
      </div>
    </div>
    <q-dialog v-model="icon">
      <q-card style="min-width: 450px">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Create Project</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-input outlined v-model="project.name" label="Name" />
          <q-input
            v-model="project.description"
            outlined
            class="q-pt-sm"
            label="Description"
            type="textarea"
          ></q-input>

          <q-input
            outlined
            label="Color Code of Project"
            v-model="project.colorCode"
            :rules="['anyColor']"
            class="my-input q-pt-sm"
          >
            <template v-slot:append>
              <q-icon name="colorize" class="cursor-pointer">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                  <q-color v-model="project.colorCode" />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>

          <q-input outlined v-model="project.deadline" label="Optional Deadline">
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                  <q-date v-model="project.deadline" mask="YYYY-MM-DD HH:mm" />
                </q-popup-proxy>
              </q-icon>
            </template>

            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy transition-show="scale" transition-hide="scale">
                  <q-time v-model="project.deadline" mask="YYYY-MM-DD HH:mm" format24h />
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <q-btn label="Create Project" icon="add"  class="full-width q-mt-md" color="primary"></q-btn>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script lang="ts">

export default {
  name: 'PageIndex',
  data () {
    return {
      data: [1, 2, 3],
      icon: false,
      project: {
        name: '',
        description: '',
        colorCode: '#027be3',
        deadline: ''
      }
    }
  },
  methods: {
    sendMe (key: string) {
      this.$router.push('/projects/' + key)
    }
  }
}
</script>
