<?php

namespace Helpdesk\Ext\Factories;

use Helpdesk\Ext\Exporters\ContactExporter;
use Helpdesk\Ext\Exporters\CompanyExporter;

class ExportFactory
{
    public static function createExporter($type)
    {
        switch ($type) {
            case 'contact':
                return new ContactExporter();
            case 'company':
                return new CompanyExporter();
            default:
                throw new \Exception('Unknown export type');
        }
    }
}