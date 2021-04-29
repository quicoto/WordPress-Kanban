<template>
  <div class="bg-light rounded pt-3 pl-3 pr-3 pb-0">
    <b-overlay :show="showLoading" rounded="sm">

      <h2 v-if="!this.$route.params.board_id">All boards</h2>
      <b-row v-for="(board, index) in boards" :key="board.id">
        <b-col v-if="index > 0" cols="12" class="mt-3 mb-2">
          <hr>
        </b-col>

        <b-col cols="12">
          <h2 class="mb-3">{{ board.name }}</h2>
        </b-col>

        <b-col md="4">
          <h4 class="mb-3 text-danger d-flex justify-content-between">
            <span><b-icon icon="clipboard-check"></b-icon> Backlog</span>
            <b-icon class="pointer" icon="plus" @click="newItem.board = board.term_id" v-b-modal.modal-1></b-icon>
          </h4>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 1)" :key="item.ID">
            <b-card
              border-variant="danger"
              header-bg-variant="danger"
              header-text-variant="white"
            >
              <template #header>
                <div class="d-flex justify-content-between">
                  <h6 class="mb-0">
                    <b-icon
                      class="pointer"
                      icon="pencil"
                      v-b-modal.modal-2
                      @click="editItem.ID = item.ID; editItem.title = item.post_title; editItem.content = item.post_content"></b-icon>
                    {{ item.post_title }}
                  </h6>
                  <span class="actions">
                    <b-icon icon="arrow-clockwise" @click="changeStatus(item.ID, 2)"></b-icon>
                    <b-icon icon="check-square" class="ml-1" @click="changeStatus(item.ID, 3)"></b-icon>
                  </span>
                </div>
              </template>
              <b-card-text>
                <span v-html="item.post_content.replace(/(?:\r\n|\r|\n)/g, '<br />')"></span>
                <small class="d-block text-right pt-2">{{ item.date }}</small>
              </b-card-text>
            </b-card>
          </b-card-group>

          <div class="text-center" v-show="board.items > 3">
            <b-button pill variant="outline-secondary" @click="newItem.board = board.term_id" v-b-modal.modal-1  ><b-icon icon="plus"></b-icon> New</b-button>
          </div>
        </b-col>

        <b-col md="4" v-if="board.items.length > 0">
          <h4 class="mb-3 text-primary"><b-icon icon="arrow-clockwise"></b-icon> In progress</h4>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 2)" :key="item.ID">
            <b-card
              border-variant="primary"
              header-bg-variant="primary"
              header-text-variant="white"
            >
              <template #header>
                <div class="d-flex justify-content-between">
                  <h6 class="mb-0">
                    <b-icon
                      class="pointer"
                      icon="pencil"
                      v-b-modal.modal-2
                      @click="editItem.ID = item.ID; editItem.title = item.post_title; editItem.content = item.post_content"></b-icon>
                    {{ item.post_title }}
                  </h6>
                  <span class="actions">
                    <b-icon icon="clipboard-check" @click="changeStatus(item.ID, 1)"></b-icon>
                    <b-icon icon="check-square" class="ml-1" @click="changeStatus(item.ID, 3)"></b-icon>
                  </span>
                </div>
              </template>
              <b-card-text>
                <span v-html="item.post_content.replace(/(?:\r\n|\r|\n)/g, '<br />')"></span>
                <small class="d-block text-right pt-2">{{ item.date }}</small>
              </b-card-text>
            </b-card>
          </b-card-group>
        </b-col>

        <b-col md="4" v-if="board.items.length > 0">
          <h4 class="mb-3 text-success"><b-icon icon="check-square"></b-icon> Done</h4>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 3)" :key="item.ID">
            <b-card
              border-variant="success"
              header-bg-variant="success"
              header-text-variant="white"
            >
              <template #header>
                <div class="d-flex justify-content-between">
                  <h6 class="mb-0">
                    <b-icon
                      class="pointer"
                      icon="pencil"
                      v-b-modal.modal-2
                      @click="editItem.ID = item.ID; editItem.title = item.post_title; editItem.content = item.post_content"></b-icon>
                    {{ item.post_title }}
                  </h6>
                  <span class="actions">
                    <b-icon icon="arrow-clockwise" class="ml-1" @click="changeStatus(item.ID, 2)"></b-icon>
                    <b-icon icon="trash" class="ml-1" @click="changeStatus(item.ID, 4)"></b-icon>
                  </span>
                </div>
              </template>
              <b-card-text>
                <span v-html="item.post_content.replace(/(?:\r\n|\r|\n)/g, '<br />')"></span>
                <small class="d-block text-right pt-2">{{ item.date }}</small>
              </b-card-text>
            </b-card>
          </b-card-group>
        </b-col>
      </b-row>
    </b-overlay>

    <b-modal
      ref="create-modal"
      id="modal-1"
      title="New item"
      hide-footer
      @hidden="newItem.title = ''; newItem.content = ''; newItem.board = null;">
       <b-form @submit="createItem()">
        <b-form-group
          id="input-group-1"
          label="Title"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            v-model="newItem.title"
            type="text"
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-3" label="Board" label-for="input-3">
          <b-form-select
            id="input-3"
            v-model="newItem.board"
            :options="boardOptions"
            required
          ></b-form-select>
        </b-form-group>

         <b-form-group
          id="input-group-2"
          label="Item content"
          label-for="input-2"
        >
          <b-form-textarea
            required
            id="input-2"
            v-model="newItem.content"
            rows="3"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>

        <div class="text-right">
          <b-button type="submit" variant="primary" :disabled="newItem.content.length <= 0">Create</b-button>
        </div>
      </b-form>
    </b-modal>

    <b-modal
      ref="update-modal"
      id="modal-2"
      title="Edit item"
      hide-footer
      @hidden="editItem.title = ''; editItem.content = ''; editItem.board = null;">
       <b-form @submit="updateItem()">
        <b-form-group
          id="input-group-3"
          label="Title"
          label-for="editItemTitle"
        >
          <b-form-input
            id="editItemTitle"
            v-model="editItem.title"
            type="text"
          ></b-form-input>
        </b-form-group>

         <b-form-group
          id="input-group-4"
          label="Item content"
          label-for="editItemContent"
        >
          <b-form-textarea
            required
            id="editItemContent"
            v-model="editItem.content"
            rows="3"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>

        <div class="text-right">
          <b-button type="submit" variant="primary" :disabled="editItem.content.length <= 0">Update</b-button>
        </div>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import { endpoints } from '@/values';

export default {
  name: 'Boards',
  data: function() {
    return {
      boards: [],
      showLoading: true,
      editItem: {
        ID: null,
        content: '',
        title: ''
      },
      newItem: {
        content: '',
        title: '',
        board: null
      }
    }
  },
  computed: {
    boardOptions: function() {
      return this.boards.map(i => {
        return {
          value: i.term_id,
          text: i.name
        }
      });
    }
  },
  methods: {
    fetchResources: function() {
      let endpoint = window.kanban_.restUrl

      if ( this.$route.params.board_id ) {
        endpoint += `${endpoints.board}/${this.$route.params.board_id}`
      } else {
        endpoint += endpoints.allBoards
      }

      this.showLoading = true;

      fetch(endpoint)
        .then(response => response.json())
        .then(boards => {
          this.boards = boards;
          this.showLoading = false;

          if ( this.$route.params.board_id ) {
            const metaTitle = this.boards[0].name
            document.title = document.title.replace('%board%', metaTitle);
          }
        });
    },
    createItem: function() {
      this.$refs['create-modal'].hide();

      const data = {
        board: this.newItem.board,
        post_title: this.newItem.title,
        post_content: this.newItem.content,
        status: 1
      };
      const options = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      };

      fetch(`${window.kanban_.restUrl}${endpoints.createItem}`, options)
        .then(() => {
          this.fetchResources();
        });

    },
    updateItem: function() {
      this.$refs['update-modal'].hide();

      const data = {
        ID: this.editItem.ID,
        post_title: this.editItem.title,
        post_content: this.editItem.content
      };
      const options = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      };

      fetch(`${window.kanban_.restUrl}${endpoints.updateItem}`, options)
        .then(() => {
          this.fetchResources();
        });

    },
    changeStatus: function (itemId, status) {
       const data = {
        itemId,
        status
      };
      const options = {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
      };

      fetch(`${window.kanban_.restUrl}${endpoints.updateItemStatus}`, options)
        .then(() => {
          this.fetchResources();
        });
    }
  },
  created: function() {
    this.fetchResources();
  },
  mounted: function() {
    // Using the bookmark
    if (this.$route.query.title
      && this.$route.query.content
      && this.$route.query.board) {
      this.newItem.content = this.$route.query.content;
      this.newItem.title = this.$route.query.title;
      this.newItem.board = +this.$route.query.board;

      this.$bvModal.show('modal-1');
      this.$router.replace({});
    }
  },
  watch: {
    $route() {
      this.fetchResources();
    }
  }
}
</script>

<style lang="scss" scoped>
.card-header,
.card-body {
  padding: 0.5rem .75rem;
}

.card-header {
  h6 {
    display: flex;
    max-width: 90%;

    svg {
      margin-right: 10px;
    }
  }
}

.actions > * {
  cursor: pointer;
}
</style>