import { mount } from '@vue/test-utils'
import SearchBox from './SearchBar.vue' 

describe('SearchBox.vue', () => {
  it('binds input to broker and emits update:broker', async () => {
    const wrapper = mount(SearchBox, {
      props: { broker: '' }
    })

    const input = wrapper.find('input')
    await input.setValue('Broker1')

    expect(wrapper.emitted('update:broker')).toBeTruthy()
    expect(wrapper.emitted('update:broker')[0]).toEqual(['Broker1'])
  })

  it('emits search-all if input is empty on button click', async () => {
    const wrapper = mount(SearchBox, { props: { broker: '' } })

    await wrapper.find('button').trigger('click')

    expect(wrapper.emitted('search-all')).toBeTruthy()
    expect(wrapper.emitted('search')).toBeFalsy()
  })

  it('emits search if input is non-empty on button click', async () => {
    const wrapper = mount(SearchBox, { props: { broker: 'abc' } })

    await wrapper.find('button').trigger('click')

    expect(wrapper.emitted('search')).toBeTruthy()
    expect(wrapper.emitted('search-all')).toBeFalsy()
  })

  it('emits search on enter key press with non-empty input', async () => {
    const wrapper = mount(SearchBox, { props: { broker: 'xyz' } })

    await wrapper.find('input').trigger('keyup.enter')

    expect(wrapper.emitted('search')).toBeTruthy()
  })

  it('emits search-all on enter key press with empty input', async () => {
    const wrapper = mount(SearchBox, { props: { broker: '' } })

    await wrapper.find('input').trigger('keyup.enter')

    expect(wrapper.emitted('search-all')).toBeTruthy()
  })
})
