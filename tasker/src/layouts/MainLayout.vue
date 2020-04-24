<template>
  <q-layout view="hHh lpR fFf">
    <q-header reveal bordered
              :class="$q.dark.isActive ? 'bg-dark text-white' : 'bg-white text-grey-14'">
      <div class="row q-pr-md q-pl-md ">

      <q-toolbar>
        <q-toolbar-title class="cursor-pointer" @click="$router.push('/')">
          TaskManager
        </q-toolbar-title>
        <q-space></q-space>
        <q-btn round flat icon="notifications" no-caps @click="notifdraw = !notifdraw" v-if="logged">
          <q-badge color="red" floating>{{notifs.length}}</q-badge>
        </q-btn >
        <q-btn flat round :icon="$q.dark.isActive? 'wb_sunny' : 'brightness_4'"
               :color="$q.dark.isActive? 'white' : 'dark'"
               no-caps @click="globalDark = !globalDark" v-if="logged"></q-btn>
        <q-btn label="Projects" to="/" flat icon="apps" no-caps v-if="logged"></q-btn>
        <q-btn label="Profile" icon="arrow_drop_down" class="q-ml-xs" flat no-caps v-if="logged">
          <q-menu>
            <q-list style="min-width: 100px">
              <q-item clickable  v-close-popup to="/profile">
                <q-item-section avatar>
                  <q-icon  name="person_outline" />
                </q-item-section>
                <q-item-section>Profile</q-item-section>
              </q-item>
              <q-item clickable  v-close-popup to="/logout">
                <q-item-section avatar>
                  <q-icon  name="navigate_before" />
                </q-item-section>
                <q-item-section>Log out</q-item-section>
              </q-item>
            </q-list>
          </q-menu>
        </q-btn>
        <q-btn label="Login" icon="person" to="/login" class="q-ml-xs" flat no-caps v-if="!logged"></q-btn>
        <q-btn label="Register" icon="person_add" to="/register" class="q-ml-xs" flat no-caps v-if="!logged"></q-btn>
      </q-toolbar>
      </div>
    </q-header>
    <q-page-container>
      <router-view />
    </q-page-container>
    <q-drawer
      v-model="notifdraw"
      :width="350"
      side="right" overlay bordered behavior="desktop"
      :breakpoint="500"
      :content-style="{ backgroundColor: ($q.dark.isActive ? '#1D1D1D' :' #eef2f3') }"
    >
      <q-scroll-area class="fit">
        <q-list>
          <q-item-label header class="text-center"> <span class="text-weight-bold">Notifications</span> <q-space/> <q-btn flat round icon="close" class="fixed-top-right" @click="notifdraw = !notifdraw"></q-btn></q-item-label>
          <q-item v-for="(n, index) in notifs" :key="index">
            <q-card flat class="full-width">
              <q-card-section>
                <q-icon color="primary" size="2em" name="apps" />
                <span class="text-weight-bold">
                    Project Invitation
                </span> <br/>
                <span class="text-positive">
                    &nbsp;{{n.project.owner.name}}
                </span> invited you to <span class="text-warning">
                    {{n.project.name}}
                </span> <br/>
                <q-btn  label="Accept" color="green" flat icon="done" no-caps @click="acceptPerm(n)"></q-btn>&nbsp;
                <q-btn  label="Decline" flat color="red" icon="close" no-caps @click="declinePerm(n)"></q-btn>
              </q-card-section>
            </q-card>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>
  </q-layout>
</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */

import { LocalStorage } from 'quasar'
import { mapActions } from 'vuex'
export default {
  data () {
    return {
      globalDark: false,
      notifdraw: false,
      logged: LocalStorage.has('access_token'),
      notifs: LocalStorage.has('access_token') ? LocalStorage.getItem('user').ups.filter(item => parseInt(item.accept_status) === 0) : []
    }
  },
  methods: {
    ...mapActions('memmbers', ['updateUps']),
    declinePerm (n) {
      n.accept_status = 2
      this.updateUps(n).then(response => {
        this.$root.$emit('updateProject')
        console.log(response)
      }).catch(error => {
        console.log(error)
      })
    },
    acceptPerm (n) {
      n.accept_status = 1
      this.updateUps(n).then(response => {
        this.$root.$emit('updateProject')
        console.log(response)
      }).catch(error => {
        console.log(error)
      })
    },
    updateNotifs () {
      this.notifs = LocalStorage.has('access_token') ? LocalStorage.getItem('user').ups.filter(item => parseInt(item.accept_status) === 0) : []
    }
  },
  beforeCreate () {
    this.$q.dark.set(LocalStorage.getItem('dark'))
    this.$axios.defaults.headers.common.Authorization = 'Bearer ' + LocalStorage.getItem('access_token')
    this.$root.$on('logged', () => {
      this.logged = true
    })
    this.$root.$on('logout', () => {
      this.logged = false
    })
    this.$root.$on('updatenots', () => {
      console.log('updatenots')
      this.updateNotifs()
    })
  },
  beforeDestroy () {
    // Don't forget to turn the listener off before your component is destroyed
    this.$root.$on('logged', () => {
      this.logged = true
    })
    this.$root.$on('logged', () => {
      this.logged = true
    })
    this.$root.$off('updatenots', () => {
      this.updateNotifs()
    })
  },
  watch: {
    globalDark: function (val) {
      LocalStorage.set('dark', val)
      this.$q.dark.set(LocalStorage.getItem('dark'))
    }
  }
}
</script>
