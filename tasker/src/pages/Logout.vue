<template>
  <q-page padding>
    Loggint you out .....
  </q-page>
</template>

<script>
  import { LocalStorage } from 'quasar';
export default {
  name: 'Logout',
  created () {
    LocalStorage.remove('access_token')
    LocalStorage.remove('user')
    this.$root.$emit('logout')
    this.$router.push('/login')
  }
}
</script>
