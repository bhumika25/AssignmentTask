<template>
    <div class="table-container">
        <table class="beautiful-table">
            <thead>
                <tr>
                    <th>Policy Number</th>
                    <th>Customer ID</th>
                    <th>Insured Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Broker Name</th>
                    <th>Renewal Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(policy, index) in policies" :key="policy.policy_number"
                    :style="{ 'animation-delay': index * 0.1 + 's' }"
                    :class="['slide-enter-active']">
                    <td class="policy-number">{{ policy.policy_number }}</td>
                    <td class="customer-id">{{ policy.customer_id }}</td>
                    <td class="amount">£{{ format(policy.insured_amount) }}</td>
                    <td class="start-date">{{ policy.start_date }}</td>
                    <td class="end-date">{{ policy.end_date }}</td>
                    <td class="broker-name">{{ policy.broker }}</td>
                    <td class="renewal-date">{{ policy.renewal_date }}</td>
                    <td><p :class="['status', getStatusClass(policy.status)]"> {{ policy.status }}</p></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
      policies: {
        type: Array,
        default: () => []
      }
    },
    methods: {
        format(amount) {
            return new Intl.NumberFormat('en-GB').format(amount);
        },
        parseDate(dateStr) {
            const [day, month, year] = dateStr.split('/');
            const date = new Date(`${year}-${month}-${day}`);
            return isNaN(date) ? new Date('Invalid Date') : date;
        },
        getStatusClass(status) {
            return {
                'status-active': status === 'Active',
                'status-expired': status === 'Expired',
                'status-upcoming': status === 'Upcoming'
            };
        }
    }
}
</script>
