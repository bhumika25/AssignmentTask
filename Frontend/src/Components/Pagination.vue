<template>
  <div v-if="totalPages > 1" class="pagination-container">
    <div class="pagination-info">
      Showing {{ start + 1 }} to {{ end }} of {{ total }} policies
    </div>

    <div class="pagination-controls">
      <button @click="changePage(1)" :disabled="currentPage === 1">⏮️</button>
      <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1">◀️</button>

      <span v-for="page in visiblePages" :key="page">
        <button 
          v-if="page !== '...'" 
          :class="{ active: page === currentPage }"
          @click="changePage(page)"
        >{{ page }}</button>
        <span v-else class="pagination-ellipsis">...</span>
      </span>

      <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">▶️</button>
      <button @click="changePage(totalPages)" :disabled="currentPage === totalPages">⏭️</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ['total', 'currentPage', 'perPage'],
  emits: ['page-change'],
  computed: {
    totalPages() {
      return Math.ceil(this.total / this.perPage);
    },
    start() {
      return (this.currentPage - 1) * this.perPage;
    },
    end() {
      const end = this.currentPage * this.perPage;
      return end > this.total ? this.total : end;
    },
    visiblePages() {
      const total = this.totalPages;
      const current = this.currentPage;
      const pages = [];

      if (total <= 7) {
        for (let i = 1; i <= total; i++) pages.push(i);
      } else {
        pages.push(1);
        if (current > 4) pages.push('...');
        for (let i = Math.max(2, current - 1); i <= Math.min(total - 1, current + 1); i++) {
          pages.push(i);
        }
        if (current < total - 3) pages.push('...');
        pages.push(total);
      }

      return pages;
    }
  },
  methods: {
    changePage(page) {
    if (page < 1) page = 1;
    else if (page > this.totalPages) page = this.totalPages;
    if (page !== this.currentPage) {
      this.$emit('page-change', page);
    }
  }
  }
};
</script>
