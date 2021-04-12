<template>
  <div class="myBoards">
    <div class="text-center">
      <b-icon v-show="showLoading" icon="circle-fill" animation="throb" font-scale="4"></b-icon>
    </div>
    <div v-show="!showLoading">
      <h4 class="mb-3 text-light d-flex justify-content-between">
        <span>
          <b-icon icon="folder"></b-icon> Your Boards
        </span>
        <span v-b-toggle.collapse-3>
          <span class="when-open"><b-icon icon="eye-slash"></b-icon></span>
          <span class="when-closed"><b-icon icon="eye"></b-icon></span>
        </span>
      </h4>
      <b-collapse visible id="collapse-3">
        <b-list-group v-if="boards" class="mb-3">
          <router-link
            to="/"
            custom
            v-slot="{ href, navigate, isExactActive }"
          >
            <b-list-group-item :active="isExactActive" @click="navigate" :href="href" >
              View all
            </b-list-group-item>
          </router-link>
          <router-link
            v-for="board in boards" :key="board.id"
            :to="'/board/' + board.term_id"
            custom
            v-slot="{ href, navigate, isActive }"
          >
            <b-list-group-item :active="isActive" @click="navigate" :href="href" >
              {{ board.name }} ({{board.items.length}})
            </b-list-group-item>
          </router-link>
        </b-list-group>
      </b-collapse>
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

<style lang="scss" scoped>
@import '~bootstrap/scss/_functions';
@import '~bootstrap/scss/_variables';
@import '~bootstrap/scss/mixins/_breakpoints';

@include media-breakpoint-up(lg) {
  .myBoards {
    position: sticky;
    top: 20px;
  }
}

.collapsed > .when-open,
.not-collapsed > .when-closed {
  display: none;
}
</style>