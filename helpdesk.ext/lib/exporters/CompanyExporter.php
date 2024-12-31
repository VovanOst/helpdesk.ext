<?php

namespace Helpdesk\Ext\Exporters;

use Helpdesk\Ext\Interfaces\Exportable;
use Bitrix\Crm\CompanyTable;

class CompanyExporter implements Exportable
{
    public function getData()
    {
        return CompanyTable::getList([
            'select' => ['ID', 'TITLE', 'PHONE', 'EMAIL'],
        ])->fetchAll();
    }

    public function getHeaders()
    {
        return ['ID', 'TITLE', 'PHONE', 'EMAIL'];
    }
}