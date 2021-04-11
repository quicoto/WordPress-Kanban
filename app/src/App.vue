<template>
  <div class="app">
    <b-container fluid>
      <b-row class="bg-dark">
        <b-col offset-lg="2" cols="12" md="9" lg="10" class="text-light pt-3 pb-3">
          <h1 class="h4 m-0"><b-icon icon="clipboard-check"></b-icon> Kanban</h1>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" lg="3" xl="2" class="bg-dark pt-3">
          <MyBoards/>
        </b-col>
        <b-col cols="12" lg="9" xl="10" class="pt-3">
          <router-view></router-view>
        </b-col>
      </b-row>
      <b-row class="bg-dark">
        <b-col offset-md="3" offset-lg="2" cols="12" md="9" lg="10" class="text-light pt-3 pb-3">
          Created with <b-icon icon="heart-fill"></b-icon> by <a href="https://ricard.blog/" class="text-light">Ricard Torres</a>
        </b-col>
      </b-row>
    </b-container>
  </div>
</template>

<script>
import MyBoards from './components/MyBoards.vue'

export default {
  name: 'App',
  components: {
    MyBoards
  }
}
</script>

<style lang="scss">
@import '~bootstrap/scss/_functions';
@import '~bootstrap/scss/_variables';

body {
  background-color: $dark;
}

h1, h2, h3, h4, h5 {
  font-weight: 300 !important;
}

.app { max-width: 1800px; margin: 0 auto; }
.pointer { cursor: pointer; }
</style>