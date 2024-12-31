<?php

namespace Helpdesk\Ext\Exporters;

use Helpdesk\Ext\Interfaces\Exportable;
use Bitrix\Crm\ContactTable;

class ContactExporter implements Exportable
{
    public function getData()
    {
        return ContactTable::getList([
            'select' => ['ID', 'NAME', 'LAST_NAME', 'PHONE', 'EMAIL'],
        ])->fetchAll();
    }

    public function getHeaders()
    {
        return ['ID', 'NAME', 'LAST_NAME', 'PHONE', 'EMAIL'];
    }
}