<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Services/StatsService.php';

class StatsServiceTest extends TestCase {
    private StatsService $service;

    protected function setUp(): void {
        $this->service = new StatsService();
    }

    public function testCalculateReturnsCorrectStats() {
        $policies = [
            [
                'status' => 'Active',
                'customer_id' => 1,
                'start_date' => '2024-01-01',
                'end_date' => '2024-01-11',
                'insured_amount' => 1000
            ],
            [
                'status' => 'Active',
                'customer_id' => 2,
                'start_date' => '2024-01-05',
                'end_date' => '2024-01-10',
                'insured_amount' => 2000
            ],
            [
                'status' => 'Expired',
                'customer_id' => 3,
                'start_date' => '2023-01-01',
                'end_date' => '2023-12-31',
                'insured_amount' => 1500
            ],
            [
                'status' => 'Upcoming',
                'customer_id' => 4,
                'start_date' => '2025-01-01',
                'end_date' => '2025-12-31',
                'insured_amount' => 500
            ],
        ];

        $stats = $this->service->calculate($policies);

        $this->assertEquals(2, $stats['total_policies']);
        $this->assertEquals(2, $stats['unique_customers']);
        $this->assertEquals(3000, $stats['total_insured_amount']);
        $this->assertGreaterThan(0, $stats['avg_policy_duration_days']);
        $this->assertEquals(1, $stats['expired']);
        $this->assertEquals(1, $stats['upcoming']);
    }

    public function testCalculateReturnsZeroStatsWhenNoPolicies() {
        $stats = $this->service->calculate([]);
        $this->assertEquals(0, $stats['total_policies']);
        $this->assertEquals(0, $stats['unique_customers']);
        $this->assertEquals(0, $stats['total_insured_amount']);
        $this->assertEquals(0, $stats['avg_policy_duration_days']);
        $this->assertEquals(0, $stats['expired']);
        $this->assertEquals(0, $stats['upcoming']);
    }
}
