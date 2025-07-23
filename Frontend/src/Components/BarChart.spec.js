import { mount } from '@vue/test-utils'
import BarChart from './BarChart.vue'


jest.mock('vue-chartjs', () => ({
  Bar: {
    template: '<canvas />',
    props: ['data', 'options'],
  },
}))

describe('BarChart', () => {
  it('renders', () => {
    const wrapper = mount(BarChart, {
      props: {
        chartData: { labels: ['A'], datasets: [{ data: [1] }] },
        title: 'Test Chart',
      },
    })
    expect(wrapper.text()).toContain('Test Chart')
    expect(wrapper.find('canvas').exists()).toBe(true)
  })
})
