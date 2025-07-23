<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Utils/DataFormatter.php';
require_once __DIR__ . '/../src/Parsers/Broker1Parser.php';

class Broker1ParserTest extends TestCase {
    private DataFormatter $formatter;
    private Broker1Parser $parser;

    protected function setUp(): void {
        $this->formatter = new DataFormatter();
        $this->parser = new Broker1Parser($this->formatter);
    }

    public function testParseReturnsFormattedPolicies() {
        $rows = [
            [
                'PolicyNumber' => 'PN123',
                'InsuredAmount' => '1000',
                'StartDate' => '01/01/2023',
                'EndDate' => '01/01/2024',
                'ClientRef' => 'C123',
                'RenewalDate' => '31/12/2023'
            ],
            [
                'PolicyNumber' => 'PN124',
                'InsuredAmount' => '2000',
                'StartDate' => 'Not Known',
                'EndDate' => '01/01/2025',
                'ClientRef' => 'C124',
                'RenewalDate' => '31/12/2024'
            ]
        ];

        $policies = $this->parser->parse($rows);

        $this->assertCount(2, $policies);

        $this->assertEquals('PN123', $policies[0]['policy_number']);
        $this->assertEquals(1000.0, $policies[0]['insured_amount']);
        $this->assertEquals('01/01/2023', $policies[0]['start_date']);
        $this->assertEquals('01/01/2024', $policies[0]['end_date']);
        $this->assertEquals('C123', $policies[0]['customer_id']);
        $this->assertEquals('Broker1', $policies[0]['broker']);
        $this->assertEquals('31/12/2023', $policies[0]['renewal_date']);
        $this->assertIsString($policies[0]['status']);

        // For second row, start date inferred
        $this->assertEquals('01/01/2024', $policies[1]['start_date']);
    }
}
