<template>
  <div class="row q-pr-xs q-pl-xs">
    <q-toolbar class="text-primary">
      <q-toolbar-title>
        {{project.name}}
      </q-toolbar-title>
      <q-btn flat dense icon="menu" @click="drawer = !drawer" label="Menu"/>
    </q-toolbar>
    <q-drawer
      v-model="drawer"
      :width="350"
      side="right" overlay bordered behavior="desktop"
      :breakpoint="500"
      :content-style="{ backgroundColor: ($q.dark.isActive ? '#1D1D1D' :' #eef2f3') }"
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
              <q-item-label class="text-weight-bold" v-if="project.owner">
                {{project.owner.name}}
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
                {{project.description}}
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon color="primary" name="timelapse" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Deadline</q-item-label>
              <q-item-label caption>
                {{formatDates(project.deadline)}}
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple>
            <q-item-section avatar>
              <q-icon :style="'color:' + project.color_code" name="palette" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Color</q-item-label>
              <q-item-label caption>
                {{project.color_code}}
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple @click="isEdit = !isEdit" v-if="user.id === parseInt(project.owner_id)">
            <q-item-section avatar>
              <q-icon color="green" name="edit" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Edit Project</q-item-label>
              <q-item-label caption>
                Edit project properties.
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple @click="delete2 = !delete2" v-if="user.id === parseInt(project.owner_id)">
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
          <q-item clickable v-ripple >
            <q-item-section avatar>
              <q-avatar  size="32px">
                <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
              </q-avatar>
            </q-item-section>
            <q-item-section v-if="project.owner">
              <q-item-label>{{project.owner.name}}</q-item-label>
              <q-item-label caption v-if="project.owner.email">
                {{project.owner.email}}
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple v-for="(up, index) in filterUps" :key="index">
            <q-item-section avatar>
              <q-avatar  size="32px">
                <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label>{{up.user.name}}</q-item-label>
              <q-item-label caption>
                {{up.user.email}}
              </q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple @click="openAdd.bool = !openAdd.bool" v-if="user.id === parseInt(project.owner_id)">
            <q-item-section avatar>
              <q-avatar  size="32px">
                <q-icon color="red" name="add" />
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label>Add User</q-item-label>
              <q-item-label caption>
                Add user to your project and give them permission.
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
    <q-dialog v-model="isEdit">
      <q-card style="min-width: 250px; width: 450px">
        <q-card-section class="row items-center q-pb-none">
          <div class="text-h6">Edit Project</div>
          <q-space />
          <q-btn icon="close" flat round dense v-close-popup />
        </q-card-section>

        <q-card-section>
          <q-form @submit.prevent="sProject">
            <q-input outlined v-model="project.name" label="Name" required />
            <q-input
              v-model="project.description"
              outlined
              class="q-pt-sm"
              label="Description"
              type="textarea"
              required
            ></q-input>

            <q-input
              outlined
              label="Color Code of Project"
              v-model="project.color_code"
              :rules="['anyColor']"
              class="my-input q-pt-sm"
              required
            >
              <template v-slot:append>
                <q-icon name="colorize" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-color v-model="project.color_code" />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>

            <q-input outlined v-model="project.deadline" label="Optional Deadline" required>
              <template v-slot:prepend>
                <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-date v-model="project.deadline" mask="YYYY-MM-DD HH:mm" />
                  </q-popup-proxy>
                </q-icon>
              </template>

              <template v-slot:append>
                <q-icon name="access_time" class="cursor-pointer">
                  <q-popup-proxy transition-show="scale" transition-hide="scale">
                    <q-time v-model="project.deadline" mask="YYYY-MM-DD HH:mm" format24h />
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
            <q-btn label="Save Project" type="submit" icon="save" :loading="load" class="full-width q-mt-md" color="green"></q-btn>
          </q-form>
        </q-card-section>
      </q-card>
    </q-dialog>
    <add-user :open-add="openAdd" :project="project"/>
  </div>
</template>

<script>
import { date } from 'quasar'
import { mapActions } from 'vuex'
import AddUser from './AddUser'
export default {
  components: { AddUser },
  props: ['project', 'user'],
  name: 'ProjectNav',
  data () {
    return {
      openAdd: {
        bool: false
      },
      selected: null,
      delete2: false,
      drawer: false,
      isEdit: false,
      load: false
    }
  },
  methods: {
    ...mapActions('projects', ['deleteProject', 'updateProject']),
    sProject () {
      this.load = true
      this.updateProject(this.project).then(response => {
        this.load = false
        this.$emit('editProject')
        this.isEdit = false
      }).catch(error => {
        this.isEdit = false
        this.load = false
        console.log(error)
      })
    },
    deleteProj (id) {
      this.deleteProject(this.project.id).then(response => {
        console.log(response)
        this.$router.push('/')
      }).catch(error => {
        console.log(error)
      })
    },

  },
  computed: {
    formatDates () {
      return timeStamp => date.formatDate(timeStamp, 'YYYY-MM-DD HH:mm:ss')
    },
    filterUps () {
      if (this.project.ups) {
        return this.project.ups.filter(item => parseInt(item.accept_status) === 1)
      } else {
        return []
      }
    }
  }
}
</script>
