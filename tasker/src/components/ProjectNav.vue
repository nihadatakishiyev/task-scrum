<template>
  <div class="row q-pr-xs q-pl-xs">
    <q-toolbar class="text-primary">
      <q-toolbar-title>
        Project Title
      </q-toolbar-title>
      <q-btn flat dense icon="menu" @click="drawer = !drawer" label="Menu"/>
    </q-toolbar>
    <q-drawer
      v-model="drawer"
      :width="350"
      side="right" overlay bordered behavior="desktop"
      :breakpoint="500"
      :content-style="{ backgroundColor: '#eef2f3' }"
    >
      <q-scroll-area class="fit">
        <q-list  >
          <q-item-label header class="text-center"> <span class="text-weight-bold">Menu</span> <q-space/> <q-btn flat round icon="close" class="fixed-top-right" @click="drawer = !drawer"></q-btn></q-item-label>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon color="primary" name="person" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Made By</q-item-label>
              <q-item-label caption>
                Ogtay Huseynov
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon color="primary" name="description" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Description</q-item-label>
              <q-item-label caption>
                Set the content filtering level to restrict
                apps that can be downloaded
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon color="primary" name="palette" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Color</q-item-label>
              <q-item-label caption>
                Change Background Color
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple @click="delete2 = !delete2">
            <q-item-section avatar>
              <q-icon color="red" name="delete" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Delete Project</q-item-label>
              <q-item-label caption>
                Delete current project perminantly??
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item-label header class="text-center"> <span class="text-weight-bold">Members</span> <q-space/></q-item-label>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-avatar  size="32px">
                <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label>Ogtay Huseynov</q-item-label>
              <q-item-label caption>
                okkkkkk@ok.ok
              </q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>
    <q-dialog v-model="delete2" persistent>
      <q-card>
        <q-card-section class="row items-center">
          <q-avatar icon="delete" color="red" text-color="white" />
          <span class="q-ml-sm text-weight-bold">Do you really want to delete project??</span>
        </q-card-section>

        <q-card-actions align="right">
          <q-btn flat label="Cancel" color="primary" v-close-popup />
          <q-btn label="Yes" flat color="red" @click="deleteProj(selected)" v-close-popup />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>import { mapActions } from 'vuex'
export default {
  props: ['project'],
  name: 'ProjectNav',
  data () {
    return {
      selected: null,
      delete2: false,
      drawer: false

    }
  },
  methods: {
    ...mapActions('projects', ['deleteProject']),
    deleteProj (id) {
      this.deleteProject(this.project.id).then(response => {
        console.log(response)
        this.$router.push('/projects')
      }).catch(error => {
        console.log(error)
      })
    }
  }
}
</script>
