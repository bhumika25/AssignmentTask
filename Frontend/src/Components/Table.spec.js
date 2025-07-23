import { mount } from '@vue/test-utils'
import PolicyTable from './Table.vue'

describe('PolicyTable.vue', () => {
  beforeAll(() => {
    global.Intl = {
      NumberFormat: jest.fn().mockImplementation(() => ({
        format: jest.fn((num) => num.toLocaleString('en-GB')),
      })),
    }
  })

  const policies = [
    {
      policy_number: 'P001',
      customer_id: 'C001',
      insured_amount: 12345.67,
      start_date: '01/01/2023',
      end_date: '31/12/2023',
      broker: 'Broker1',
      renewal_date: '01/01/2024',
      status: 'Active',
    },
    {
      policy_number: 'P002',
      customer_id: 'C002',
      insured_amount: 7654.32,
      start_date: '01/02/2023',
      end_date: '31/01/2024',
      broker: 'Broker2',
      renewal_date: '01/02/2024',
      status: 'Expired',
    },
    {
      policy_number: 'P003',
      customer_id: 'C003',
      insured_amount: 5000,
      start_date: '01/03/2023',
      end_date: '28/02/2024',
      broker: 'Broker3',
      renewal_date: '01/03/2024',
      status: 'Upcoming',
    },
  ]

  it('renders the correct number of rows', () => {
    const wrapper = mount(PolicyTable, { props: { policies } })
    expect(wrapper.findAll('tbody tr')).toHaveLength(policies.length)
  })

  it('renders no rows if policies prop is empty or undefined', () => {
    const wrapperEmpty = mount(PolicyTable, { props: { policies: [] } })
    expect(wrapperEmpty.findAll('tbody tr')).toHaveLength(0)

    const wrapperMissing = mount(PolicyTable)
    expect(wrapperMissing.findAll('tbody tr')).toHaveLength(0)
  })

  it('displays all policy details correctly', () => {
    const wrapper = mount(PolicyTable, { props: { policies } })
    const firstRow = wrapper.find('tbody tr')

    expect(firstRow.find('.policy-number').text()).toBe('P001')
    expect(firstRow.find('.customer-id').text()).toBe('C001')
    expect(firstRow.find('.amount').text()).toBe('£12,345.67')
    expect(firstRow.find('.start-date').text()).toBe('01/01/2023')
    expect(firstRow.find('.end-date').text()).toBe('31/12/2023')
    expect(firstRow.find('.broker-name').text()).toBe('Broker1')
    expect(firstRow.find('.renewal-date').text()).toBe('01/01/2024')
    expect(firstRow.find('.status').text().trim()).toBe('Active')
  })

  it('applies correct status classes', () => {
    const wrapper = mount(PolicyTable, { props: { policies } })
    const rows = wrapper.findAll('tbody tr')

    expect(rows[0].find('.status').classes()).toContain('status-active')
    expect(rows[1].find('.status').classes()).toContain('status-expired')
    expect(rows[2].find('.status').classes()).toContain('status-upcoming')
  })

  it('getStatusClass returns correct class object for all statuses', () => {
    const wrapper = mount(PolicyTable)

    expect(wrapper.vm.getStatusClass('Active')).toEqual({
      'status-active': true,
      'status-expired': false,
      'status-upcoming': false,
    })
    expect(wrapper.vm.getStatusClass('Expired')).toEqual({
      'status-active': false,
      'status-expired': true,
      'status-upcoming': false,
    })
    expect(wrapper.vm.getStatusClass('Upcoming')).toEqual({
      'status-active': false,
      'status-expired': false,
      'status-upcoming': true,
    })
    expect(wrapper.vm.getStatusClass('Unknown')).toEqual({
      'status-active': false,
      'status-expired': false,
      'status-upcoming': false,
    })
  })

  it('format method returns correctly formatted strings', () => {
    const wrapper = mount(PolicyTable)
    expect(wrapper.vm.format(0)).toBe('0')
    expect(wrapper.vm.format(1234.5)).toBe('1,234.5')
    expect(wrapper.vm.format(1234567.89)).toBe('1,234,567.89')
    expect(wrapper.vm.format(-1234.56)).toBe('-1,234.56')
  })

  it('parseDate correctly parses valid date strings', () => {
    const wrapper = mount(PolicyTable)
    const date = wrapper.vm.parseDate('25/12/2023')

    expect(date).toBeInstanceOf(Date)
    expect(date.getFullYear()).toBe(2023)
    expect(date.getMonth()).toBe(11)
    expect(date.getDate()).toBe(25)
  })

  it('parseDate returns Invalid Date for invalid strings', () => {
    const wrapper = mount(PolicyTable)
    const date = wrapper.vm.parseDate('invalid-date')
    expect(date.toString()).toBe('Invalid Date')
  })

  it('handles reactive update when policies prop changes', async () => {
    const wrapper = mount(PolicyTable, { props: { policies: [] } })
    expect(wrapper.findAll('tbody tr')).toHaveLength(0)

    await wrapper.setProps({ policies })
    expect(wrapper.findAll('tbody tr')).toHaveLength(policies.length)
  })

  it('handles missing optional fields gracefully', () => {
    const incompletePolicies = [
      {
        policy_number: null,
        customer_id: undefined,
        insured_amount: 0,
        start_date: '',
        end_date: '',
        broker: '',
        renewal_date: '',
        status: '',
      },
    ]
    const wrapper = mount(PolicyTable, { props: { policies: incompletePolicies } })

    const row = wrapper.find('tbody tr')
    expect(row.find('.policy-number').text()).toBe('')
    expect(row.find('.customer-id').text()).toBe('')
    expect(row.find('.amount').text()).toBe('£0')
    expect(row.find('.start-date').text()).toBe('')
    expect(row.find('.end-date').text()).toBe('')
    expect(row.find('.broker-name').text()).toBe('')
    expect(row.find('.renewal-date').text()).toBe('')
    expect(row.find('.status').text().trim()).toBe('')
  })

  it('renders table headers correctly', () => {
    const wrapper = mount(PolicyTable, { props: { policies: [] } })

    const thead = wrapper.find('thead')
    expect(thead.exists()).toBe(true)

    const headerRow = thead.find('tr')
    expect(headerRow.exists()).toBe(true)

    const thElements = headerRow.findAll('th')
    expect(thElements).toHaveLength(8)

    const ths = wrapper.findAll('thead th')

    expect(ths[0].text()).toBe('Policy Number')
    expect(ths[1].text()).toBe('Customer ID')
    expect(ths[2].text()).toBe('Insured Amount')
    expect(ths[3].text()).toBe('Start Date')
    expect(ths[4].text()).toBe('End Date')
    expect(ths[5].text()).toBe('Broker Name')
    expect(ths[6].text()).toBe('Renewal Date')
    expect(ths[7].text()).toBe('Status')

  })
});
