<style scoped>
.chart-row {
  display: flex;
  flex-wrap: wrap;
  gap: 4rem;
  justify-content: space-around;
}
.chart-item {
  flex: 1 1 30%;
  max-width: 40%; 
}
</style>

<template>
  <div v-if="ready" class="chart-row">
    <div class="chart-item">
      <BarChart :chart-data="insuredByStatus" title="Total Insured Amount per Status" />
    </div>
    <div class="chart-item">
      <BarChart :chart-data="policiesByBroker" title="Number of Policies per Broker" />
    </div>
    <div class="chart-item">
      <PieChart :chart-data="policyCountByStatus" title="Policy Count per Status" />
    </div>
  </div>
  <div v-else class="text-center text-gray-500 p-10">
    <p v-if="error">{{ error }}</p>
    <p v-else>Loading charts...</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import BarChart from '../Components/BarChart.vue'
import PieChart from '../Components/PieChart.vue'

const insuredByStatus = ref(null)
const policiesByBroker = ref(null)
const policyCountByStatus = ref(null)
const ready = ref(false)
const error = ref(null)

onMounted(async () => {
  try {
    const res = await fetch(`http://localhost:8000/api/getpolicies`);

    if (!res.ok) throw new Error(`API error: ${res.status}`)

    const policies = await res.json()

    const statusGroups = {}
    const brokerGroups = {}
    const statusCount = {}

    for (const p of policies) {
      statusGroups[p.status] = (statusGroups[p.status] || 0) + p.insured_amount
      brokerGroups[p.broker] = (brokerGroups[p.broker] || 0) + 1
      statusCount[p.status] = (statusCount[p.status] || 0) + 1
    }

    insuredByStatus.value = {
      labels: Object.keys(statusGroups),
      datasets: [
        {
          label: 'Insured Amount',
          backgroundColor: '#4CAF50',
          data: Object.values(statusGroups),
        },
      ],
    }

    policiesByBroker.value = {
      labels: Object.keys(brokerGroups),
      datasets: [
        {
          label: 'Policy Count',
          backgroundColor: '#2196F3',
          data: Object.values(brokerGroups),
        },
      ],
    }

    policyCountByStatus.value = {
      labels: Object.keys(statusCount),
      datasets: [
        {
          label: 'Count',
          backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
          data: Object.values(statusCount),
        },
      ],
    }

    ready.value = true
  } catch (err) {
    error.value = err.message || 'Failed to load data'
    ready.value = false
  }
})
</script>
