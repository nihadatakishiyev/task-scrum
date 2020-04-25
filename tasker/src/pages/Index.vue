<template>
  <q-page class="q-ma-md">
    <div class="row">
      <div class="col text-center">
        <span class="text-weight-medium text-h4 ">All Projects</span>
      </div>
    </div>
    <div class="row q-col-gutter-y-m">
      <div class="col col-xs-12 col-sm-6 col-md-3">
        <q-card class="cursor-pointer q-ma-md" @click="icon = true" flat bordered>
          <q-card-section class="text-center">
            <span class="text-weight-medium text-h6">Create Project</span> <br/>
            <q-icon name="add" size="40px" class="text-grey-14"></q-icon>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-6 col-md-3" v-for="(proj, index) in projects" :key="index">
        <q-card class="cursor-pointer q-ma-md"
                :style="'border-radius: 5px; border-bottom: 5px solid ' + proj.color_code" flat bordered
                @click="sendMe(proj.id)">
          <q-card-section class="">
            <div class="text-center">
              <span class="text-weight-bold text-h5">{{proj.name}}</span> <br/>
            </div>
            <q-list >
              <q-item >
                <q-item-section avatar>
                  <q-icon  name="person_outline" />
                </q-item-section>

                <q-item-section class="text-weight-bold">{{proj.owner.name}}</q-item-section>
              </q-item>
              <q-item >
                <q-item-section avatar>
                  <q-icon  name="timelapse" />
                </q-item-section>

                <q-item-section class="text-weight-bold">{{formatDates(proj.deadline)}}</q-item-section>
              </q-item>
            </q-list>
            <!--<span class="text-weight-bold"><q-icon name="person_outline" size="2em"></q-icon>{{proj.owner.name}}</span> <br/>-->
            <!--<span class="text-weight-bold text-body2">-->
              <!--<q-icon name="timelapse" size="2em"></q-icon>-->
              <!--{{formatDates(proj.deadline)}}</span> <br/>-->
          </q-card-section>
        </q-card>
      </div>
    </div>
    <q-dialog v-model="icon">
      <q-card style="min-width: 250px; width: 450px">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Create Project</div>
          <q-space/>
          <q-btn icon="close" flat round dense v-close-popup/>
        </q-card-section>

        <q-card-section>
          <q-form @submit.prevent="cProject">
            <q-input outlined v-model="project.name" label="Name" required/>
            <q-input
              v-model="project.description"
              outlined
              class="q-pt-sm"
              label="Description"
              type="textarea"
              required
            ></q-input>

            <q-input
              outlined
              label="Color Code of Project"
              v-model="project.color_code"
              :rules="['anyColor']"
              class="my-input q-pt-sm"
              required
            >
              <template v-slot:append>
                <q-icon name="colorize" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-color v-model="project.color_code"/>
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>

            <q-input outlined v-model="project.deadline" label="Optional Deadline" required>
              <template v-slot:prepend>
                <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-date v-model="project.deadline" mask="YYYY-MM-DD HH:mm"/>
                  </q-popup-proxy>
                </q-icon>
              </template>

              <template v-slot:append>
                <q-icon name="access_time" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-time v-model="project.deadline" mask="YYYY-MM-DD HH:mm" format24h/>
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
            <q-btn label="Create Project" type="submit" icon="add" :loading="load" class="full-width q-mt-md"
                   color="primary"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>

  </q-page>
</template>

<script lang="ts">
/* eslint-disable @typescript-eslint/camelcase */

import { mapActions } from 'vuex'
import {date, LocalStorage} from 'quasar'

export default {
  name: 'PageIndex',
  data () {
    return {
      data: [1, 2, 3],
      icon: false,
      user: null,
      project: {
        owner_id: 1,
        name: '',
        description: '',
        is_completed: 0,
        color_code: '#027be3',
        deadline: ''
      },
      projects: [],
      load: false
    }
  },
  methods: {
    ...mapActions('projects', ['createProject', 'getProjects']),
    sendMe (key: string) {
      this.$router.push('/projects/' + key)
    },
    formatDates (timeStamp) {
      return  date.formatDate(timeStamp, 'YYYY-MM-DD HH:mm')
    },
    cProject () {
      this.load = true
      this.project.owner_id = this.user.id
      this.createProject(this.project).then(response => {
        this.load = false
        this.icon = false
        this.updateProjects()
        console.log(response)
      }).catch(error => {
        this.load = false
        this.icon = false
        console.log(error)
      })
    },
    updateProjects () {
      this.$q.loading.show()
      this.getProjects('asd').then(response => {
        this.user = response.data[0]
        LocalStorage.set('user', this.user)
        this.$root.$emit('updatenots')
        this.projects = response.data[0].project
        const ups = response.data[0].ups
        if (ups) {
          let index
          for (index = 0; index < ups.length; index++) {
            const nups = ups[index]
            if (parseInt(nups["accept_status"]) === 1) {
              console.log('ups--', nups)
              this.projects.push(nups.project)
            }
          }
        }
        this.projects = this.projects.sort(function (a, b) {
          return b.created_at < a.created_at ? -1 : 1
        })
        console.log(this.projects)
        this.$q.loading.hide()
      }).catch(error => {
        this.$q.loading.hide()
        console.log(error)
      })
    }
  },
  created () {
    this.updateProjects()
    this.$root.$on('updateProject', () => {
      this.updateProjects()
    })
  },
  beforeDestroy () {
    this.$root.$off('updateProject', () => {
      this.updateProjects()
    })
  }
}
</script>
