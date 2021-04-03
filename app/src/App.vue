<template>
  <div>
    <b-container fluid>
      <b-row class="bg-dark mb-3">
        <b-col offset-md="3" offset-lg="2" cols="12" md="9" lg="10" class="text-light pt-3 pb-3">
          <h1 class="h4 m-0"><b-icon icon="clipboard-check"></b-icon> Kanban</h1>
        </b-col>
      </b-row>
      <b-row>
        <b-col cols="12" md="3" lg="2">
          <MyBoards/>
        </b-col>
        <b-col cols="12" md="9" lg="10">
          <Boards/>
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
import Boards from './components/Boards.vue'
import MyBoards from './components/MyBoards.vue'

export default {
  name: 'App',
  components: {
    Boards,
    MyBoards
  }
}
</script>