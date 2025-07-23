<?php
class StatsService {
    public function calculate(array $policies): array {
        $customerCount = array_unique(array_column($policies, 'customer_id'));
        $active = array_filter($policies, fn($p) => $p['status'] === 'Active');
        $expired = array_filter($policies, fn($p) => $p['status'] === 'Expired');
        $upcoming = array_filter($policies, fn($p) => $p['status'] === 'Upcoming');
        $unique = array_unique(array_column($active, 'customer_id'));
        $durations = array_map(fn($p) =>
            (strtotime($p['end_date']) - strtotime($p['start_date'])) / 86400,
            $active
        );
        return [
            'all_policies_count' => count($policies),
            'all_unique_customers' => count($customerCount),
            'total_policies' => count($active),
            'unique_customers' => count($unique),
            'total_insured_amount' => array_sum(array_column($active, 'insured_amount')),
            'avg_policy_duration_days' => count($durations) ? array_sum($durations) / count($durations) : 0,
            'expired' => count($expired),
            'upcoming' => count($upcoming)
        ];
    }
}
