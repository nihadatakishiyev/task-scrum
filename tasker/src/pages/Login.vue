<template>
  <q-page padding>
    <div class="row">
      <div class="col col-xs-12 col-sm-2 col-md-4 gt-xs"></div>
      <div class="col col-xs-12 col-sm-8 col-md-4">
        <q-card flat bordered>
          <q-card-section class="text-center">
            <span class="text-grey-14 text-weight-bold text-h5">Login</span>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="submit()">
              <q-input outlined v-model="user.email" label="Email" type="email" />
            <q-input outlined v-model="user.password" label="Password" type="password" class="q-mt-sm"/>
            <q-btn type="submit" label="Login" icon="lock_open" flat class="full-width q-mt-sm bg-primary text-white"></q-btn>
            </q-form>
            <q-btn type="submit" label="Register" icon="person_add" to="/register" flat class="full-width q-mt-sm"></q-btn>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-2 col-md-4 gt-xs"></div>
    </div>
  </q-page>
</template>

<script>
export default {
  data () {
    return {
      user: {
        email: '',
        password: ''
      }
    }
  }
}
</script>
