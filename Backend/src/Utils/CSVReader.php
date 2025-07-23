<?php
class CSVReader {
    public function read(string $filePath): array {
        $rows = [];

        if (!file_exists($filePath)) {
            return []; 
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            $header = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                if ($data === null || count($data) !== count($header)) {
                    continue;
                }
                $rows[] = array_combine($header, $data);
            }
            fclose($handle);
        }

        return $rows;
    }
}
