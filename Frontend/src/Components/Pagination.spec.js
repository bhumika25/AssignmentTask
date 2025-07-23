import { mount } from '@vue/test-utils'
import Pagination from './Pagination.vue'

describe('Pagination.vue', () => {
  it('renders pagination info and buttons', async () => {
    const wrapper = mount(Pagination, {
      props: { total: 100, currentPage: 1, perPage: 10 }
    })

    expect(wrapper.text()).toContain('Showing 1 to 10 of 100 policies')
    expect(wrapper.find('button:disabled').exists()).toBe(true)

    const page2Button = wrapper.findAll('button').filter(btn => btn.text() === '2')[0]
    await page2Button.trigger('click')
    expect(wrapper.emitted('page-change')[0]).toEqual([2])
  })

  it('does not emit page-change for current page', async () => {
    const wrapper = mount(Pagination, {
      props: { total: 50, currentPage: 3, perPage: 10 }
    })

    const page3Button = wrapper.findAll('button').filter(btn => btn.text() === '3')[0]
    await page3Button.trigger('click')

    expect(wrapper.emitted('page-change')).toBeUndefined()
  })
})
