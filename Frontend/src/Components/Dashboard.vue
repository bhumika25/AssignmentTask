<template>
  <div>
    <div v-if="stats" class="Dashboard-background">
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
        <p>Active Policies: {{ stats.total_policies }}</p> 
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
        <p>Active Unique Customers: {{ stats.unique_customers }}</p>
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
          <p>Active Total Insured Amount: £{{ stats.total_insured_amount }}</p>
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
          <p>Active Avg Policy Duration: {{ stats.avg_policy_duration_days.toFixed(2)}} days</p>
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
        <p>Expired Policies: {{ stats.expired }}</p> 
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
        <p>Upcoming Policies: {{ stats.upcoming }}</p>
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
          <p>Count of All Policies:{{ stats.all_policies_count }}</p>
        </div>
      </div>
      <div class="Dashboard-Item">
        <div class="Dashboard-Block">
          <p>All Unique Customers: {{ stats.all_unique_customers}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return { stats: null }
  },
  mounted() {
    fetch('http://localhost:8000/api/stats').then(r => r.json()).then(data => this.stats = data)
  }
}
</script>
