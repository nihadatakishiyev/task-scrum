<template>
  <q-layout view="hHh lpR fFf">

    <q-header reveal bordered class="bg-white text-grey-14">
      <q-toolbar>
        <q-toolbar-title>
          Title
        </q-toolbar-title>
        <q-space></q-space>
        <q-btn label="Home" to="/" flat></q-btn>
        <q-btn label="Second" to="/project/11" class="q-ml-xs" flat></q-btn>
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
