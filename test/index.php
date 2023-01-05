<?php
// namespace MyBooksCatalog;
use Bitrix\MyBooksCatalog\BookTable;
use Bitrix\Main\Application;
use Bitrix\Main\Entity\Base;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Type;

\Bitrix\Main\Loader::includeModule('mybookscatalog');

if (!Application::getConnection()->isTableExists(Base::getInstance('Bitrix\MyBooksCatalog\BookTable')->getDBTableName())) {
    Base::getInstance('Bitrix\MyBooksCatalog\BookTable')->createDBTable();
}

// dd(BookTable::getMap());

$result = BookTable::add(array(
    'ISBN' => '978-0321127426',
    'TITLE' => 'Patterns of Enterprise Application Architecture',
    'PUBLISH_DATE' => new Type\Date('2002-11-16', 'Y-m-d'),
    'EDITIONS_ISBN' => array("123","321")
));

if ($result->isSuccess())
{
    $id = $result->getId();
} else {
    $errors = $result->getErrorMessages();
    var_dump($errors);
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");