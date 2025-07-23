<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Utils/CSVReader.php';
require_once __DIR__ . '/../src/Services/PolicyService.php';
require_once __DIR__ . '/../src/Parsers/BrokerParserInterface.php';


class PolicyServiceTest extends TestCase {
    public function testGetAllPoliciesWithValidFileAndData() {
        $mockParser = $this->createMock(BrokerParserInterface::class);
        $mockParser->method('parse')->willReturn([['policy_number' => '123', 'name' => 'Test Policy']]);

        $mockReader = $this->createMock(CSVReader::class);
        $mockReader->method('read')->willReturn([['some', 'data']]);

        $testFile = tempnam(sys_get_temp_dir(), 'testcsv');
        file_put_contents($testFile, "dummy content");

        $parsers = [
            ['file' => $testFile, 'parser' => $mockParser]
        ];

        $service = new PolicyService($parsers, $mockReader);
        $result = $service->getAllPolicies();

        $this->assertCount(1, $result);
        $this->assertEquals('Test Policy', $result[0]['name']);

        unlink($testFile);
    }

    public function testGetAllPoliciesSkipsMissingFile() {
        $mockParser = $this->createMock(stdClass::class);
        $mockReader = $this->createMock(CSVReader::class);

        $parsers = [['file' => '/no/such/file.csv', 'parser' => $mockParser]];

        $service = new PolicyService($parsers, $mockReader);
        $result = $service->getAllPolicies();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testGetAllPoliciesReturnsEmptyWhenNoRows() {
        $mockParser = $this->createMock(stdClass::class);
        $mockReader = $this->createMock(CSVReader::class);
        $mockReader->method('read')->willReturn([]);

        $testFile = tempnam(sys_get_temp_dir(), 'emptycsv');
        file_put_contents($testFile, "");

        $parsers = [['file' => $testFile, 'parser' => $mockParser]];

        $service = new PolicyService($parsers, $mockReader);
        $result = $service->getAllPolicies();

        $this->assertIsArray($result);
        $this->assertEmpty($result);

        unlink($testFile);
    }
}
