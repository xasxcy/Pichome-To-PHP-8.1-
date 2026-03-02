<?php
declare(strict_types=1);

// Minimal export-only check for PHPExcel on PHP 8.1
require __DIR__ . '/../core/class/class_PHPExcel.php';
require __DIR__ . '/../core/class/PHPExcel/IOFactory.php';

$outDir = __DIR__ . '/output';
if (!is_dir($outDir) && !mkdir($outDir, 0777, true) && !is_dir($outDir)) {
    fwrite(STDERR, "Failed to create output directory: {$outDir}\n");
    exit(1);
}

$xlsxFile = $outDir . '/php81_export_test.xlsx';

$excel = new PHPExcel();
$sheet = $excel->setActiveSheetIndex(0);
$sheet->setTitle('ExportCheck');
$sheet->setCellValue('A1', 'id');
$sheet->setCellValue('B1', 'name');
$sheet->setCellValue('C1', 'created_at');
$sheet->setCellValue('A2', 1);
$sheet->setCellValue('B2', 'php81-export-ok');
$sheet->setCellValue('C2', date('Y-m-d H:i:s'));

$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$writer->save($xlsxFile);

if (!is_file($xlsxFile) || filesize($xlsxFile) === 0) {
    fwrite(STDERR, "Export failed: file not generated or empty\n");
    exit(2);
}

echo "OK: {$xlsxFile}\n";
echo "SIZE: " . filesize($xlsxFile) . "\n";
