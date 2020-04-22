<template>
  <q-layout view="hHh lpR fFf">

    <q-header reveal bordered class="bg-white text-grey-14">
      <q-toolbar>
        <q-toolbar-title>
          Title
        </q-toolbar-title>
        <q-space></q-space>
        <q-btn label="Projects" to="/" flat icon="apps" no-caps></q-btn>
        <q-btn label="Profile" icon="person_outline" to="/profile" class="q-ml-xs" flat no-caps></q-btn>
        <q-btn label="Login" icon="person" to="/login" class="q-ml-xs" flat no-caps></q-btn>
        <q-btn label="Register" icon="person_add" to="/register" class="q-ml-xs" flat no-caps></q-btn>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <router-view />
    </q-page-container>

  </q-layout>
</template>

<script>
export default {
  data () {
    return {
    }
  }
}
</script>
