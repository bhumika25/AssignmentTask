<?php
class DataFormatter {
    public function format(string $dateStr): string {
        $date = DateTime::createFromFormat('d/m/Y', $dateStr);
        if (!$date) {
            throw new InvalidArgumentException("Invalid date: $dateStr");
        }
        return $date->format('d/m/Y');
    }

    public function inferStartDateFromEndDate(string $endDateStr): string {
        $end = DateTime::createFromFormat('d/m/Y', $endDateStr);
        if (!$end) {
            throw new InvalidArgumentException("Invalid end date: $endDateStr");
        }
        $start = clone $end;
        $start->modify('-1 year');
        return $start->format('d/m/Y');
    }

     public function isActive(string $start, string $end): string {
        $now = new DateTime();
        $startDate = DateTime::createFromFormat('d/m/Y', $start);
        $endDate = DateTime::createFromFormat('d/m/Y', $end);
        if ($now < $startDate) {
            return "Upcoming";
        } else if ($now >= $startDate && $now <= $endDate) {
            return "Active";
        } else if ($now > $endDate) {
            return "Expired";
        } else {
            return "Unknown";
        }
    }
}
