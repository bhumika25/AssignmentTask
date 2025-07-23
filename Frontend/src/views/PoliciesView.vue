<template>
  <div>
    <h2 style="text-align: left;">Policies Table</h2>
    <SearchBar 
      v-model:broker="broker" 
      @search="fetchPolicies"
      @search-all="getPolicies"
    />

    <Loading v-if="loading" />

    <transition name="fade">
      <div v-if="policies.length && !loading">
        <Table :policies="paginatedPolicies" />
        <Pagination
          :total="policies.length"
          :current-page="currentPage"
          :per-page="recordsPerPage"
          @page-change="goToPage"
        />
      </div>
    </transition>

    <NoResults 
      v-if="!policies.length && !loading && searched" 
      :broker="broker"
    />
  </div>
</template>

<script>
import SearchBar from '../Components/SearchBar.vue';
import Table from '../Components/Table.vue';
import Pagination from '../Components/Pagination.vue';
import Loading from '../Components/Loading.vue';
import NoResults from '../Components/NoResults.vue';

export default {
  name: 'PoliciesView',
  components: {
    SearchBar,
    Table,
    Pagination,
    Loading,
    NoResults,
  },
  data() {
    return {
      broker: '',
      policies: [],
      loading: false,
      searched: false,
      currentPage: 1,
      recordsPerPage: 5
    };
  },
  computed: {
    totalPages() {
      return Math.ceil(this.policies.length / this.recordsPerPage);
    },
    paginatedPolicies() {
      const start = (this.currentPage - 1) * this.recordsPerPage;
      return this.policies.slice(start, start + this.recordsPerPage);
    }
  },
  methods: {
    async getPolicies() {
      this.loading = true;
      this.searched = false;
      try {
        const res = await fetch(`http://localhost:8000/api/getpolicies`);
        this.policies = await res.json();
        this.currentPage = 1;
      } catch (err) {
        console.error('Error:', err);
        this.policies = [];
      } finally {
        this.loading = false;
        this.searched = true;
      }
    },
    async fetchPolicies() {
      if (!this.broker.trim()) return;

      this.loading = true;
      this.searched = false;

      try {
        const res = await fetch(`http://localhost:8000/api/policies?broker=${this.broker}`);
        this.policies = await res.json();
        this.currentPage = 1;
      } catch (err) {
        console.error('Error:', err);
        this.policies = [];
      } finally {
        this.loading = false;
        this.searched = true;
      }
    },
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    }
  },
  mounted() {
    this.getPolicies();
  }
};
</script>
