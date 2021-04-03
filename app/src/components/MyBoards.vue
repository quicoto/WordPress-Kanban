<template>
  <div>
    <div class="text-center">
      <b-icon v-show="showLoading" icon="circle-fill" animation="throb" font-scale="4"></b-icon>
    </div>
    <div v-show="!showLoading">
      <h3><b-icon icon="folder"></b-icon> Your Boards</h3>
      <ul v-if="boards">
        <li v-for="board in boards" :key="board.id">
          {{ board.name }} ({{board.items.length}})
        </li>
      </ul>
      <hr>
    </div>
  </div>
</template>

<script>
import { endpoints } from '@/values'

export default {
  name: 'MyBoards',
  data: function() {
    return {
      boards: [],
      showLoading: true
    }
  },
  created: function() {
    fetch(`${window.kanban_.restUrl}${endpoints.allBoards}`)
    .then(response => response.json())
    .then(boards => {
      this.boards = boards;
      this.showLoading = false;
    });
  }
}
</script>