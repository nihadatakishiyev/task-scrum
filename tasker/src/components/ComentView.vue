<template>

  <div>
      <div class="text-center">
        <span class="text-weight-bold text-grey-14">Comments</span>
      </div>
      <div class="q-mt-sm-lg">
        <div v-for="(item, index) in 4" :key="index" class="q-mt-lg">
          <span class="text-weight-bold text-grey-14"> Ogtay Huseynov</span> &nbsp;&nbsp;
          <span class="text-weight-bold text-grey-14">{{item}}</span>
          <q-card flat>
            <q-card-section>
              ASDASDASDASDASDASDASDASDASDASD ASDASDASDAS ASDASDASDasdasdsa asdasdasdsd
            </q-card-section>
          </q-card>
        </div>
      </div>
  </div>

</template>

<script>
export default {
  name: 'CommentView',
  data () {
    return {}
  }
}
</script>
