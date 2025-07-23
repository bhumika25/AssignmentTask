import { mount } from '@vue/test-utils'
import { createRouter, createWebHistory } from 'vue-router'
import SideNav from './SideNav.vue'

const routes = [
  { path: '/', component: { template: '<div>Dashboard</div>' } },
  { path: '/policies', component: { template: '<div>Policies Table</div>' } },
  { path: '/charts', component: { template: '<div>Analytics</div>' } },
]

describe('SideNav.vue', () => {
  let router
  let wrapper

  beforeEach(async () => {
    router = createRouter({
      history: createWebHistory(),
      routes,
      linkActiveClass: 'active-link',
    })

    wrapper = mount(SideNav, {
      global: {
        plugins: [router],
      },
    })

    await router.isReady()
  })

  it('renders sidebar and all links', () => {
    expect(wrapper.classes()).toContain('sidebar')

    const links = wrapper.findAll('a')
    expect(links).toHaveLength(3)

    expect(links[0].text()).toBe('Dashboard')
    expect(links[0].attributes('href')).toBe('/')
    expect(links[1].text()).toBe('Policies Table')
    expect(links[1].attributes('href')).toBe('/policies')
    expect(links[2].text()).toBe('Analytics')
    expect(links[2].attributes('href')).toBe('/charts')
  })

  it('applies active-link class correctly on /policies route', async () => {
    await router.push('/policies')
    await wrapper.vm.$nextTick()

    const links = wrapper.findAll('a')

    expect(links[1].classes()).toContain('active-link')
    expect(links[0].classes()).not.toContain('active-link')
    expect(links[2].classes()).not.toContain('active-link')
  })

  it('applies active-link class correctly on / route', async () => {
    await router.push('/')
    await wrapper.vm.$nextTick()

    const links = wrapper.findAll('a')

    expect(links[0].classes()).toContain('active-link')
    expect(links[1].classes()).not.toContain('active-link')
    expect(links[2].classes()).not.toContain('active-link')
  })
})
