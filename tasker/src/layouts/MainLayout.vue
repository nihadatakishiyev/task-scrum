<template>
  <q-layout view="hHh lpR fFf">
    <q-header reveal bordered
              :class="$q.dark.isActive ? 'bg-dark text-white' : 'bg-white text-grey-14'">
      <div class="row q-pr-md q-pl-md ">

      <q-toolbar>
        <q-toolbar-title>
          TaskManager
        </q-toolbar-title>
        <q-space></q-space>
        <q-btn round flat icon="notifications" no-caps @click="notifdraw = !notifdraw">
          <q-badge color="red" floating>4</q-badge>
        </q-btn>
        <q-btn flat round :icon="$q.dark.isActive? 'wb_sunny' : 'brightness_4'"
               :color="$q.dark.isActive? 'white' : 'dark'"
               no-caps @click="globalDark = !globalDark"></q-btn>
        <q-btn label="Projects" to="/" flat icon="apps" no-caps></q-btn>
        <q-btn label="Profile" icon="person_outline" to="/profile" class="q-ml-xs" flat no-caps></q-btn>
        <q-btn label="Login" icon="person" to="/login" class="q-ml-xs" flat no-caps></q-btn>
        <q-btn label="Register" icon="person_add" to="/register" class="q-ml-xs" flat no-caps></q-btn>
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
          <q-item v-for="key in 3" :key="key">
            <q-card flat>
              <q-card-section>
                <q-icon color="primary" size="2em" name="apps" />
                <span class="text-weight-bold">
                    Project Invitation
                </span> <br/>
                Ogtay Huseynov invited you to Create Website project. <br/>
                <q-btn  label="Accept" color="green" flat icon="done" no-caps></q-btn>&nbsp;
                <q-btn  label="Decline" flat color="red" icon="close" no-caps></q-btn>
              </q-card-section>
            </q-card>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>
  </q-layout>
</template>

<script>
import { LocalStorage } from 'quasar'
export default {
  data () {
    return {
      globalDark: false,
      notifdraw: false
    }
  },
  beforeCreate () {
    this.$q.dark.set(LocalStorage.getItem('dark'))
  },
  watch: {
    globalDark: function (val) {
      LocalStorage.set('dark', val)
      this.$q.dark.set(LocalStorage.getItem('dark'))
    }
  }
}
</script>
