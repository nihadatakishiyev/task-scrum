<template>
  <q-page padding>
    <div class="row">
      <div class="col col-xs-12 col-sm-2 col-md-4 gt-xs"></div>
      <div class="col col-xs-12 col-sm-8 col-md-4">
        <q-card flat bordered>
          <q-card-section class="text-center">
            <span class="text-grey-14 text-weight-bold text-h5">Register</span>
          </q-card-section>
          <q-card-section>
            <q-form @submit.prevent="register2()">
              <q-input outlined v-model="user.name" label="Full Name" required
                       autofocus
              ></q-input>
              <q-input outlined v-model="user.email" label="Email" type="email" class="q-mt-sm" required/>
              <q-input outlined v-model="user.password" label="Password" type="password" class="q-mt-sm" required/>
              <q-btn type="submit" label="Register" flat icon="person_add" class="full-width q-mt-sm bg-primary text-white"></q-btn>
            </q-form>
            <q-btn type="submit" label="Login" icon="lock_open" class="full-width q-mt-sm" to="/login" flat></q-btn>

          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-2 col-md-4 gt-xs"></div>
    </div>
  </q-page>
</template>

<script>
import { mapActions } from 'vuex'
import { LocalStorage } from 'quasar';
export default {
  data () {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      }
    }
  },
  methods: {
    ...mapActions('auth', ['register']),
    register2 () {
      this.$q.loading.show()

      this.register(this.user).then(response => {
        this.$q.loading.hide()
        LocalStorage.set('access_token', response.data.access_token)
        LocalStorage.set('user', response.data.user)
        this.$axios.defaults.headers.common.Authorization = 'Bearer ' + response.data.access_token
        this.$root.$emit('logged')
        this.$router.push('/')
        this.$forceUpdate()
        console.log(response)
      }).catch(error => {
        this.$q.loading.hide()
        console.log(error)
      })
    }
  },

}
</script>
