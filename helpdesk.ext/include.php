<?php

\Bitrix\Main\Loader::registerAutoLoadClasses(
    'helpdesk.ext',
    [
        'Helpdesk\\Ext\\Interfaces\\Exportable' => 'lib/interfaces/Exportable.php',
        'Helpdesk\\Ext\\Factories\\ExportFactory' => 'lib/factories/ExportFactory.php',
        'Helpdesk\\Ext\\Exporters\\ContactExporter' => 'lib/exporters/ContactExporter.php',
        'Helpdesk\\Ext\\Exporters\\CompanyExporter' => 'lib/exporters/CompanyExporter.php',
        'Helpdesk\\Ext\\Exporter' => 'lib/Exporter.php',
    ]
);