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
      <div class="text-center">
        <span class="text-weight-bold text-grey-14">Comments</span>
      </div>
      <div class="q-mt-sm-lg">
        <div v-for="(item, index) in comments" :key="index" class="q-mt-lg">
          <span class="text-weight-bold text-grey-14"> {{item.commenter.name}}</span> &nbsp;&nbsp;
          <span class="text-weight-bold text-grey-14 float-right">{{formatDates(item.created_at)}}</span>
          <q-card flat>
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
export default {
  name: 'CommentView',
  props: ['task'],
  data () {
    return {
      comment: {
        content: '',
        task_id: this.task.id,
        commenter_id: 3,
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
        console.log(response)
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
      this.createComment(this.comment).then(response => {
        this.comment.task_id = this.task.id
        console.log(this.comment)
        this.getComments2()
        console.log(response)
      }).catch(error => {
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
