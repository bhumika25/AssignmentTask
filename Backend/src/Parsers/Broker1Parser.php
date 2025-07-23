<?php
require_once __DIR__ . '/BrokerParserInterface.php';
require_once __DIR__ . '/../Utils/DataFormatter.php';

class Broker1Parser implements BrokerParserInterface {
    private DataFormatter $formatter;

    public function __construct(DataFormatter $formatter) {
        $this->formatter = $formatter;
    }

    public function parse(array $rows): array {
        return array_map(function ($row) {
            $startDate = ($row['StartDate'] === 'Not Known')
                ? $this->formatter->inferStartDateFromEndDate($row['EndDate'])
                : $this->formatter->format($row['StartDate']);

            $endDate = $this->formatter->format($row['EndDate']);
            $statusType = $this->formatter->isActive($startDate, $endDate);

            return [
                'policy_number' => $row['PolicyNumber'],
                'insured_amount' => (float)$row['InsuredAmount'],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'customer_id' => $row['ClientRef'],
                'broker' => 'Broker1',
                'renewal_date' => $row['RenewalDate'],
                'status' => $statusType
            ];
        }, $rows);
    }
}
