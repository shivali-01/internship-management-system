<?php
function saveToCSV($data) {
    $file = __DIR__ . '/applications.csv';
    $file_exists = file_exists($file);
    $fp = fopen($file, 'a');
    if ($fp) {
        if (!$file_exists) {
            fputcsv($fp, ['ID', 'Company Name', 'Email', 'Industry',', 'Date']);
        }
        fputcsv($fp, $data);
        fclose($fp);
    }
}
?>
