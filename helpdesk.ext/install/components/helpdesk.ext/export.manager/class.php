<?php
use Bitrix\Main\Loader;
use Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class HelpdeskExtExportManagerComponent extends CBitrixComponent
{
    public function executeComponent()
    {
        if (!Loader::includeModule('helpdesk.ext')) {
            ShowError('Модуль helpdesk.ext не установлен');
            return;
        }

        $request = Application::getInstance()->getContext()->getRequest();

        if ($request->isPost() && $request->getPost('export')) {
            $type = $request->getPost('type');
            $format = $request->getPost('format');

            if (in_array($type, ['contact', 'company']) && in_array($format, ['csv', 'xls'])) {
                \Helpdesk\Ext\Exporter::export($type, $format);
            } else {
                ShowError('Некорректные параметры экспорта');
            }
        }

        $this->includeComponentTemplate();
    }
}