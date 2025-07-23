<template>
  <div>
    <h2 class="text-lg font-bold mb-2">{{ title }}</h2>
    <Bar :data="chartData" :options="options" />
  </div>
</template>

<script setup>
import { Bar } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

defineProps({
  chartData: Object,
  title: String,
})

const options = {
  responsive: true,
  plugins: {
    legend: { position: 'top' },
  },
}
</script>
