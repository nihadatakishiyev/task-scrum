<template>
  <q-page padding>
    <div class="row">
      <div class="col col-xs-12 col-sm-2 col-md-3 gt-xs"></div>
      <div class="col col-xs-12 col-sm-8 col-md-6">
        <q-card flat bordered>
          <q-card-section class="text-center">
            <q-avatar size="155px">
              <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706">
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
                <q-tab name="activity" label="Activity" />
                <q-tab name="deadline" label="Deadlines" />
              </q-tabs>

              <q-separator />

              <q-tab-panels v-model="tab" animated>
                <q-tab-panel name="activity">
                  <div class="text-h6 text-center">Activities</div>
                  <q-timeline color="primary">
                    <q-timeline-entry
                      title="Task Created"
                      subtitle="February 22, 1986"
                      icon="comment"

                    >
                      <div>
                        link
                      </div>
                    </q-timeline-entry>

                    <q-timeline-entry
                      title="Project Creted"
                      subtitle="February 21, 1986"
                      icon="apps"
                    >
                      <div>
                          link
                      </div>
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
                  />
                </q-tab-panel>
              </q-tab-panels>
            </q-card>
          </q-card-section>
        </q-card>
      </div>
      <div class="col col-xs-12 col-sm-2 col-md-3 gt-xs"></div>
    </div>

  </q-page>
</template>

<script>
export default {
  data () {
    return {
      tab: 'activity',
      date: '2019/02/01',
      user: {
        name: 'Ogtay Huseynov',
        email: 'okkkk@ok.ok'
      }
    }
  },
  methods: {
    eventsFn (date) {
      const parts = date.split('/')
      return parts[2] % 2 === 0
    }
  }
}
</script>
