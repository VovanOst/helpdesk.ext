<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\IO\Directory;

class helpdesk_ext extends CModule
{
    public $MODULE_ID = 'helpdesk.ext';
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME = 'Helpdesk Export Module';
    public $MODULE_DESCRIPTION = 'Модуль для экспорта данных в CSV и XLS.';

    public function __construct()
    {
        $arModuleVersion = [];
        include(__DIR__ . '/version.php');
        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);

        //$this->installFiles();
        $this->installComponent();
        $this->installPage();

        echo 'Модуль успешно установлен. Перейдите на страницу <a href="/export/">/export/</a> для проверки.';
    }

    public function DoUninstall()
    {
        //$this->uninstallFiles();
        $this->uninstallComponent();
        $this->uninstallPage();

        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function installFiles()
    {
        CopyDirFiles(
            __DIR__ . '/../lib/',
            Application::getDocumentRoot() . '/local/modules/helpdesk.ext/lib/',
            true,
            true
        );
    }

    public function uninstallFiles()
    {
        //Directory::deleteDirectory(Application::getDocumentRoot() . '/local/modules/helpdesk.ext/lib/');
    }

    public function installComponent()
    {
        CopyDirFiles(
            __DIR__ . '/components/',
            Application::getDocumentRoot() . '/local/components/helpdesk.ext/',
            true,
            true
        );
    }

    public function uninstallComponent()
    {
       // Directory::deleteDirectory(Application::getDocumentRoot() . '/local/components/helpdesk.ext/');
    }

    public function installPage()
    {
        $pagePath = Application::getDocumentRoot() . '/export/index.php';

        if (!file_exists($pagePath)) {
            file_put_contents($pagePath, "<?php\nrequire(\$_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');\n");
            file_put_contents($pagePath, "\$APPLICATION->SetTitle('Экспорт данных');\n", FILE_APPEND);
            file_put_contents($pagePath, "\$APPLICATION->IncludeComponent('helpdesk.ext:export.manager', '', []);\n", FILE_APPEND);
            file_put_contents($pagePath, "require(\$_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');\n", FILE_APPEND);
        }
    }

    public function uninstallPage()
    {
        $pagePath = Application::getDocumentRoot() . '/export/index.php';

        if (file_exists($pagePath)) {
            unlink($pagePath);
        }
    }
}