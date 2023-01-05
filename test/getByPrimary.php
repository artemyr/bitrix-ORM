<?php
use Bitrix\MyBooksCatalog\BookTable;

$book = BookTable::getByPrimary(3)->fetchObject();
$value = '123';

if ($book !== null)
{
    $fieldName = 'TITLE';

    echo "get ".$book->get($fieldName)."<br>";
    $book->set($fieldName, $value);
    echo "after set ".$book->get($fieldName)."<br>";

    echo "remind ".$book->remindActual($fieldName)."<br>";
    $book->reset($fieldName);

    echo "after reset ".$book->get($fieldName)."<br>";
}