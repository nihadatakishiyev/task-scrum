<template>
  <q-page padding>
    <div class="row">
      <div class="col col-xs-12 col-sm-2 col-md-3 gt-xs"></div>
      <div class="col col-xs-12 col-sm-8 col-md-6">
        <q-card flat bordered>
          <q-card-section class="text-center">
            <q-avatar size="155px">
              <img
                src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706">
            </q-avatar>
            <br/>
            <span class="text-grey-14 text-weight-bold text-h5">{{user.name}}</span><br/>
            <span class="text-grey-14 text-weight-bold text-body1">{{user.email}}</span>
          </q-card-section>
          <q-card-section>
            <q-card flat>
              <q-tabs
                v-model="tab"
                dense
                class="text-grey"
                active-color="primary"
                indicator-color="primary"
                align="justify"
                narrow-indicator
              >
                <q-tab name="activity" label="Activity"/>
                <q-tab name="deadline" label="Deadlines"/>
              </q-tabs>

              <q-separator/>

              <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="activity">
                  <div class="text-h6 text-center">Activities</div>
                  <q-timeline color="primary">
                    <q-timeline-entry
                      v-for="(t, index) in als"
                      :key="index"
                      :title=t.action_name
                      :subtitle=covertToDate2(t.created_at)
                    >
                    </q-timeline-entry>
                  </q-timeline>
                </q-tab-panel>

                <q-tab-panel name="deadline">
                  <div class="text-h6 text-center">Deadlines</div>
                  <q-date
                    v-model="date"
                    :events="eventsFn"
                    minimal
                    class="full-width"
                    flat
                    :options="dds"
                    event-color="(date) => date[9] % 2 === 0 ? 'orange' : 'red'"
                  ></q-date>
                </q-tab-panel>
              </q-tab-panels>
            </q-card>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-2 col-md-3 gt-xs"></div>
    </div>
    <q-dialog v-model="showing" >
      <q-card style="min-width: 250px; width: 450px">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Deadlines to this Date</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-list>
            <div v-for="(da, idnex) in getCustomDate(date)" :key="idnex">
              <q-item :to="'/projects/' + da.id" clickable >
                <q-item-section avatar>
                  <q-icon name="open_in_new"></q-icon>
                </q-item-section>
                <q-item-section>
                  {{da.task_name}}
                </q-item-section>
              </q-item>
            </div>
          </q-list>
        </q-card-section>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
import { mapActions } from 'vuex'
import { LocalStorage, date } from 'quasar'

export default {
  data () {
    return {
      tab: 'activity',
      date: new Date(),
      user: [],
      profile: [],
      als: [],
      allDate: [],
      dds: [],
      showing: false
    }
  },
  methods: {
    ...mapActions('users', ['getUserProfile']),
    eventsFn (date) {
      return this.dds.includes(date)
    },
    covertToDate (timeStamp) {
      return date.formatDate(timeStamp, 'YYYY/MM/DD')
    },
    covertToDate2 (timeStamp) {
      return date.formatDate(timeStamp, 'YYYY/MM/DD HH:mm:ss')
    }
  },
  created () {
    this.user = LocalStorage.getItem('user')
    this.getUserProfile(this.$route.params.profile).then(response => {
      this.als = response.data[0].als.sort(function (a, b) {
        return b.created_at < a.created_at ? -1 : 1
      })
      this.allDate = response.data[2]
      console.log(this.allDate)
      this.dds = response.data[2].map(a => this.covertToDate(a.deadline))
    }).catch(error => {
      console.log(error)
    })
  },
  computed: {
    getCustomDate () {
      return val => this.allDate.filter(item => date.isSameDate(this.covertToDate(item.deadline), val))
    }
  },
  watch: {
    date: function (value) {
      this.showing = true
      console.log(value)
    }
  }
}
</script>
