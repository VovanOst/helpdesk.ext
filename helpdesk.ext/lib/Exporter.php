<?php

namespace Helpdesk\Ext;

use Bitrix\Main\Context;
use Bitrix\Main\Application;
use Helpdesk\Ext\Factories\ExportFactory;

class Exporter
{
    public static function export($type, $format = 'csv')
    {
        $context = Context::getCurrent();
        $response = $context->getResponse();
        $fileName = $type . '_export_' . date('Y-m-d_H-i-s') . '.' . $format;
        $filePath = Application::getDocumentRoot() . '/upload/' . $fileName;

        $exporter = ExportFactory::createExporter($type);
        $data = $exporter->getData();
        $headers = $exporter->getHeaders();

        if ($format === 'csv') {
            self::exportToCSV($headers, $data, $filePath);
        } elseif ($format === 'xls') {
            self::exportToExcelXML($headers, $data, $filePath);
        }

        $response->addHeader('Content-Type', ($format === 'csv') ? 'text/csv' : 'application/vnd.ms-excel');
        $response->addHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->flush(file_get_contents($filePath));
        unlink($filePath);
        exit;
    }

    private static function exportToCSV($headers, $data, $filePath)
    {
        $file = fopen($filePath, 'w');
        fputcsv($file, $headers);
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
        fclose($file);
    }

    private static function exportToExcelXML($headers, $data, $filePath)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:o="urn:schemas-microsoft-com:office:office"' . "\n";
        $xml .= ' xmlns:x="urn:schemas-microsoft-com:office:excel"' . "\n";
        $xml .= ' xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"' . "\n";
        $xml .= ' xmlns:html="http://www.w3.org/TR/REC-html40">' . "\n";
        $xml .= '<Worksheet ss:Name="Sheet1">' . "\n";
        $xml .= '<Table>' . "\n";

        // Заголовки
        $xml .= '<Row>';
        foreach ($headers as $header) {
            $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($header) . '</Data></Cell>';
        }
        $xml .= '</Row>' . "\n";

        // Данные
        foreach ($data as $row) {
            $xml .= '<Row>';
            foreach ($row as $cell) {
                $xml .= '<Cell><Data ss:Type="String">' . htmlspecialchars($cell) . '</Data></Cell>';
            }
            $xml .= '</Row>' . "\n";
        }

        $xml .= '</Table>' . "\n";
        $xml .= '</Worksheet>' . "\n";
        $xml .= '</Workbook>';

        file_put_contents($filePath, $xml);
    }
}