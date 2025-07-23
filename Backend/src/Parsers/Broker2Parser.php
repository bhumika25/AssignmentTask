<?php
require_once __DIR__ . '/BrokerParserInterface.php';
require_once __DIR__ . '/../Utils/DataFormatter.php';


class Broker2Parser implements BrokerParserInterface {
    private DataFormatter $formatter;

    public function __construct(DataFormatter $formatter) {
        $this->formatter = $formatter;
    }

    public function parse(array $rows): array {
        return array_map(function ($row) {
            $statusType = $this->formatter->isActive($this->formatter->format($row['InitiationDate']), $this->formatter->format($row['ExpirationDate']));
            return [
                'policy_number' => $row['PolicyRef'],
                'insured_amount' => (float)$row['CoverageAmount'],
                'start_date' => $this->formatter->format($row['InitiationDate']),
                'end_date' => $this->formatter->format($row['ExpirationDate']),
                'customer_id' => $row['ConsumerID'],
                'broker' => 'Broker2',
                'renewal_date' => $row['NextRenewalDate'],
                'status' =>$statusType
            ];
        }, $rows);
    }
}
