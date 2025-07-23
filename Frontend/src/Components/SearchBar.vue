<template>
  <div class="search-container">
    <input
      v-model="localBroker"
      placeholder="Enter text to search"
      class="search-input"
      @keyup.enter="emitSearch"
    />
    <button @click="emitSearch" class="search-button">
      Search Policies
    </button>
  </div>
</template>

<script>
export default {
  props: {
    broker: {
      type: String,
      default: ''
    }
  },
  emits: ['update:broker', 'search', 'search-all'],
  computed: {
    localBroker: {
      get() {
        return this.broker;
      },
      set(val) {
        this.$emit('update:broker', val);
      }
    }
  },
  methods: {
    emitSearch() {
       if (this.localBroker.trim() === '') {
        this.$emit('search-all'); 
      } else {
        this.$emit('search'); 
      }
    }
  }
};
</script>
