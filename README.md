# 📦 **Helpdesk.Ext — Модуль для экспорта данных в Bitrix24**  

**Назначение:** Модуль позволяет экспортировать данные (**Контакты**, **Компании**) в форматы **CSV** и **XLSX**.

---

## ⚙️ **1. Установка модуля**

### 📌 **Автоматическая установка (рекомендуемый способ)**  
1. Скопируйте файлы модуля в директорию:  
/local/modules/helpdesk.ext/
2. В административной панели Bitrix перейдите в:  
**«Marketplace → Установленные решения»**  
3. Установите модуль `Helpdesk.Ext`.  
4. Перейдите на страницу для экспорта:  
https://your-site/export/

### 🚨 **Возможные ошибки и их решения**

#### **Ошибка прав доступа к папке `/export/`**  
Если возникли ошибки, выполните:  
```bash
chmod -R 775 /path_to_bitrix/export
chown -R www-data:www-data /path_to_bitrix/export

🛠️ 2. Ручная настройка компонента
Если автоматическая установка страницы /export/ не удалась:

📌 Шаг 1: Копирование компонента вручную

cp -R /local/modules/helpdesk.ext/install/components/helpdesk.ext/export.manager /local/components/helpdesk.ext/export.manager
chmod -R 775 /local/components/helpdesk.ext/export.manager
chown -R www-data:www-data /local/components/helpdesk.ext/export.manager

📌 Шаг 2: Создание страницы вручную
Создайте папку и файл:

mkdir -p /path_to_bitrix/export
touch /path_to_bitrix/export/index.php
chmod 775 /path_to_bitrix/export/index.php
chown www-data:www-data /path_to_bitrix/export/index.php
Добавьте в index.php:

<?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Экспорт данных');
$APPLICATION->IncludeComponent('helpdesk.ext:export.manager', '', []);
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>
📌 Шаг 3: Очистка кэша
bash
Копировать код
php /path_to_bitrix/bitrix/modules/main/tools/clear_cache.php
📌 Шаг 4: Проверка работы
Перейдите на страницу:

https://your-site/export/
📝 3. Использование модуля
Откройте страницу /export/.
Выберите тип данных для экспорта (Контакты или Компании).
Выберите формат выгрузки (CSV или XLSX).
Нажмите кнопку «Экспорт».
Файл будет автоматически загружен на ваш компьютер.
📤 4. Обновление модуля
Отключите модуль через админку.
Скопируйте новые файлы модуля в /local/modules/helpdesk.ext/.
Повторите установку.
🐞 5. Отладка и поддержка
Логи ошибок: /bitrix/bitrix.log
Включение отладки PHP:
php
Копировать код
define("BX_DEBUG", true);
@ini_set("error_reporting", E_ALL);
@ini_set("display_errors", "On");
📂 6. Структура модуля
r
Копировать код
/local/modules/helpdesk.ext/
│
├── install/
│   ├── components/       <- Компоненты модуля
│   ├── export/           <- Шаблоны экспорта
│   ├── index.php         <- Скрипт установки
│
├── lib/
│   ├── Factories/        <- Фабрики
│   ├── Interfaces/       <- Интерфейсы
│   ├── Exporters/        <- Экспортеры данных
│   ├── Exporter.php      <- Главный класс экспорта
│
├── include.php           <- Подключение модуля
└── README.md             <- Инструкция


