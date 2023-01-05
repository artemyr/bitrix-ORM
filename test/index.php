<?php
use Bitrix\MyBooksCatalog\BookTable;
use Bitrix\Main\Type;
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (Loader::includeModule('mybookscatalog')) {
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
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");