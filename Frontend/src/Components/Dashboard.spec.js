import { mount } from '@vue/test-utils'
import Dashboard from './Dashboard.vue'


global.fetch = jest.fn(() =>
  Promise.resolve({
    json: () =>
      Promise.resolve({
        total_policies: 10,
        unique_customers: 8,
        total_insured_amount: 50000,
        avg_policy_duration_days: 123.456,
        expired: 2,
        upcoming: 3,
      }),
  })
)

describe('Dashboard.vue', () => {
  beforeEach(() => {
    fetch.mockClear()
  })

  it('fetches and renders stats correctly', async () => {
    const wrapper = mount(Dashboard)

    await new Promise(resolve => setTimeout(resolve, 0))
    await wrapper.vm.$nextTick()

    expect(fetch).toHaveBeenCalledTimes(1)
    expect(fetch).toHaveBeenCalledWith('/api/stats')

    const text = wrapper.text()
    expect(text).toContain('Active Policies: 10')
    expect(text).toContain('Active Unique Customers: 8')
    expect(text).toContain('Active Total Insured Amount: £50000')
    expect(text).toContain('Active Avg Policy Duration: 123.46 days')
    expect(text).toContain('Expired Policies: 2')
    expect(text).toContain('Upcoming Policies: 3')
    expect(text).toContain('Total Insured Amount: £50000')
    expect(text).toContain('Avg Policy Duration: 123.46 days')
  })
})
