import { mount } from '@vue/test-utils'
import PieChart from './PieChart.vue'

jest.mock('vue-chartjs', () => ({
  Pie: {
    template: '<canvas />',
    props: ['data', 'options'],
  },
}))

describe('PieChart.vue', () => {
  const sampleData = {
    labels: ['A', 'B'],
    datasets: [{ label: 'Test', data: [10, 20] }],
  }

  it('renders title and Pie chart', () => {
    const wrapper = mount(PieChart, {
      props: {
        chartData: sampleData,
        title: 'Sample Pie Chart',
      },
    })

    expect(wrapper.text()).toContain('Sample Pie Chart')
    expect(wrapper.find('canvas').exists()).toBe(true)
  })
})
