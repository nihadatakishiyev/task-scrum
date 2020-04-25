<template>

  <div>
    <q-card-section>
      <q-form @submit.prevent="createComment2">
        <q-input filled bottom-slots v-model="comment.content" label="Make a Comment" counter maxlength="250" required
        >
          <template v-slot:append>
            <q-btn round dense flat icon="send" type="submit" @click="createComment2"/>
          </template>
        </q-input>
      </q-form>
    </q-card-section>
    <q-card-section>
      <div class="">
        <q-icon name="comment" size="2em"></q-icon>&nbsp;
        <span class="text-weight-bold text-grey-14 text-h6">Comments</span>
      </div>
      <div class="q-mt-sm-lg">
        <div v-for="(item, index) in comments" :key="index" class="q-mt-lg">
          <q-avatar  size="32px">
            <img src="https://cdn.shopify.com/s/files/1/0064/7636/5891/products/product-image-400926614_530x@2x.jpg?v=1573914706" />
          </q-avatar>
          <span class="text-weight-bold"> {{item.commenter.name}}</span> &nbsp;&nbsp;
          <span class="text-weight-bold text-grey-14 float-right">{{formatDates(item.created_at)}}</span>
          <q-card flat bordered class="q-mt-sm">
            <q-card-section>
              {{item.content}}
            </q-card-section>
          </q-card>
        </div>
      </div>
    </q-card-section>
  </div>

</template>

<script>
/* eslint-disable @typescript-eslint/camelcase */
import { date } from 'quasar'
import { mapActions } from 'vuex'
import { LocalStorage } from 'quasar';
export default {
  name: 'CommentView',
  props: ['task'],
  data () {
    return {
      comment: {
        content: '',
        task_id: this.task.id,
        commenter_id: LocalStorage.getItem('user').id,
        is_deleted: 0
      },
      comments: []
    }
  },
  methods: {
    ...mapActions('comments', ['getComments', 'createComment']),
    getComments2 () {
      this.$q.loading.show()

      this.getComments(this.task.id).then(response => {
        this.comments = response.data[0].comments.sort( function (a, b) {
          return b.created_at < a.created_at ? -1 : 1
        })
        this.$q.loading.hide()

      }).catch(error => {
        this.$q.loading.hide()

        console.log(error)
      })
    },
    createComment2 () {
      this.$q.loading.show()

      this.createComment(this.comment).then(response => {
        this.comment.task_id = this.task.id
        this.comment.content = null
        this.$root.$emit('commentMade')
        this.getComments2()
        console.log(response)
      }).catch(error => {
        this.comment.content = null
        console.log(error)
      })
    }
  },
  created () {
    this.getComments2()
  },
  computed: {
    formatDates () {
      return timeStamp => date.formatDate(timeStamp, 'YYYY-MM-DD HH:mm:ss')
    }
  }
}
</script>
