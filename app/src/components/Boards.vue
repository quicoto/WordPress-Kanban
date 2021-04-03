<template>
  <div>
    <div class="text-center">
      <b-icon v-show="showLoading" icon="circle-fill" animation="throb" font-scale="4"></b-icon>
    </div>
    <div v-show="!showLoading && boards.length > 0">
      <h2>All boards</h2>
      <b-row v-for="board in boards" :key="board.id">
        <b-col cols="12">
          <h2 class="mb-3">{{ board.name }}</h2>
        </b-col>

        <b-col md="4">
          <h5 class="mb-3 text-danger d-flex justify-content-between">
            <span>To do</span>
            <b-button variant="outline-secondary" size="sm" @click="newItem.board = board.term_id" v-b-modal.modal-1  >
              <b-icon icon="plus"></b-icon>
            </b-button>
          </h5>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 1)" :key="item.id">
            <b-card
              border-variant="danger"
              :header="item.post_title"
              header-bg-variant="danger"
              header-text-variant="white"
            >
              <b-card-text>
                <span v-html="item.post_content"></span>
              </b-card-text>
            </b-card>
          </b-card-group>

          <div class="text-center" v-show="board.items > 3">
            <b-button pill variant="outline-secondary" @click="newItem.board = board.term_id" v-b-modal.modal-1  ><b-icon icon="plus"></b-icon> New</b-button>
          </div>
        </b-col>

        <b-col md="4" v-if="board.items.length > 0">
          <h5 class="mb-3 text-primary">In progress</h5>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 2)" :key="item.id">
            <b-card
              border-variant="primary"
              :header="item.post_title"
              header-bg-variant="primary"
              header-text-variant="white"
            >
              <b-card-text>
                <span v-html="item.post_content"></span>
              </b-card-text>
            </b-card>
          </b-card-group>
        </b-col>

        <b-col md="4" v-if="board.items.length > 0">
          <h5 class="mb-3 text-success"><b-icon icon="check-square"></b-icon> Done</h5>
          <b-card-group
            class="mb-3"
            v-for="item in board.items.filter(i => i.status === 3)" :key="item.id">
            <b-card
              border-variant="success"
              :header="item.post_title"
              header-bg-variant="success"
              header-text-variant="white"
            >
              <b-card-text>
                <span v-html="item.post_content"></span>
              </b-card-text>
            </b-card>
          </b-card-group>
        </b-col>

        <b-col cols="12" class="mt-3 mb-2">
          <hr>
        </b-col>
      </b-row>
    </div>

    <b-modal
      id="modal-1"
      title="New item"
      ok-title="Create"
      @ok="createItem()"
      @hidden="newItem.title = ''; newItem.content = ''; newItem.board = null;">
       <b-form>
        <b-form-group
          id="input-group-1"
          label="Item title"
          label-for="input-1"
        >
          <b-form-input
            id="input-1"
            v-model="newItem.title"
            type="text"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group id="input-group-3" label="Food:" label-for="input-3">
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
            id="input-2"
            v-model="newItem.content"
            rows="3"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>
      </b-form>
    </b-modal>
  </div>
</template>

<script>
import { endpoints } from '@/values'

export default {
  name: 'Boards',
  data: function() {
    return {
      boards: [],
      showLoading: true,
      newItem: {
        title: '',
        content: '',
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
      this.showLoading = true;

      fetch(`${window.kanban_.restUrl}${endpoints.allBoards}`)
        .then(response => response.json())
        .then(boards => {
          this.boards = boards;
          this.showLoading = false;
        });
    },
    createItem: function() {
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

      fetch(`${window.kanban_.restUrl}${endpoints.createPost}`, options)
        .then(() => {
          this.fetchResources();
        });

    }
  },
  created: function() {
    this.fetchResources();
  }
}
</script>