<?php
require_once __DIR__ . '/../utils/CSVReader.php';


class PolicyService {
    private array $parsers;
    private CSVReader $reader;

    public function __construct(array $parsers, CSVReader $reader) {
        $this->parsers = $parsers;
        $this->reader = $reader;
    }

    public function getAllPolicies(): array {
        $all = [];
        foreach ($this->parsers as $parserEntry) {
            $file = $parserEntry['file'];
            if (!file_exists($file) || !is_readable($file)) {
                continue;
            }

            $rows = $this->reader->read($file);
            if (!empty($rows)) {
                $policies = $parserEntry['parser']->parse($rows);
                $all = array_merge($all, $policies);
            }
        }
        return $all;
    }
}
