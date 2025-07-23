<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/utils/CSVReader.php';

class CSVReaderTest extends TestCase {
    private CSVReader $reader;

    protected function setUp(): void {
        $this->reader = new CSVReader();
    }

    public function testReadReturnsEmptyArrayForMissingFile() {
        $result = $this->reader->read('/non/existent/file.csv');
        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testReadParsesValidCsvCorrectly() {
        $csvContent = "id,name\n1,John\n2,Jane\n";
        $file = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($file, $csvContent);

        $result = $this->reader->read($file);

        $this->assertCount(2, $result);
        $this->assertEquals(['id' => '1', 'name' => 'John'], $result[0]);
        $this->assertEquals(['id' => '2', 'name' => 'Jane'], $result[1]);

        unlink($file);
    }

    public function testReadSkipsMalformedRows() {
        $csvContent = "id,name\n1,John\n2\n3,Jane,ExtraField\n4,Valid\n";
        $file = tempnam(sys_get_temp_dir(), 'csv');
        file_put_contents($file, $csvContent);

        $result = $this->reader->read($file);

        // Only rows with matching column counts are included
        $this->assertCount(2, $result);
        $this->assertEquals(['id' => '1', 'name' => 'John'], $result[0]);
        $this->assertEquals(['id' => '4', 'name' => 'Valid'], $result[1]);

        unlink($file);
    }
}
