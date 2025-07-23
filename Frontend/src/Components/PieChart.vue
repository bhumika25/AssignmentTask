<template>
  <div>
    <h2 class="text-lg font-bold mb-2">{{ title }}</h2>
    <Pie :data="chartData" :options="options" />
  </div>
</template>

<script setup>
import { Pie } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  ArcElement,
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

defineProps({
  chartData: Object,
  title: String,
})

const options = {
  responsive: true,
  plugins: {
    legend: { position: 'right' },
  },
}
</script>
