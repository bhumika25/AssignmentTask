<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../src/Utils/DataFormatter.php';

class DataFormatterTest extends TestCase {
    private DataFormatter $formatter;

    protected function setUp(): void {
        $this->formatter = new DataFormatter();
    }

    public function testFormatReturnsSameFormatForValidDate() {
        $input = '25/12/2024';
        $expected = '25/12/2024';
        $this->assertEquals($expected, $this->formatter->format($input));
    }

    public function testFormatThrowsExceptionForInvalidDate() {
        $this->expectException(InvalidArgumentException::class);
        $this->formatter->format('invalid-date');
    }

    public function testInferStartDateFromEndDateReturnsCorrectDate() {
        $endDate = '01/01/2025';
        $expectedStartDate = '01/01/2024';
        $this->assertEquals($expectedStartDate, $this->formatter->inferStartDateFromEndDate($endDate));
    }

    public function testInferStartDateFromEndDateThrowsExceptionForInvalidDate() {
        $this->expectException(InvalidArgumentException::class);
        $this->formatter->inferStartDateFromEndDate('bad-date');
    }

    public function testIsActiveReturnsUpcomingWhenNowBeforeStart() {
        $start = (new DateTime('+1 day'))->format('d/m/Y');
        $end = (new DateTime('+10 days'))->format('d/m/Y');
        $this->assertEquals('Upcoming', $this->formatter->isActive($start, $end));
    }

    public function testIsActiveReturnsActiveWhenNowBetween() {
        $start = (new DateTime('-1 day'))->format('d/m/Y');
        $end = (new DateTime('+1 day'))->format('d/m/Y');
        $this->assertEquals('Active', $this->formatter->isActive($start, $end));
    }

    public function testIsActiveReturnsExpiredWhenNowAfterEnd() {
        $start = (new DateTime('-10 days'))->format('d/m/Y');
        $end = (new DateTime('-1 day'))->format('d/m/Y');
        $this->assertEquals('Expired', $this->formatter->isActive($start, $end));
    }
}
