<?php
use Bitrix\MyBooksCatalog\BookTable;
use Bitrix\Main\Type;

$result = BookTable::add(array(
    'ISBN' => '978-0321127425',
    'TITLE' => 'Patterns of Enterprise Application Architecture',
    // 'PUBLISH_DATE' => new Type\Date('2002-11-16', 'Y-m-d'),
    'EDITIONS_ISBN' => array("123","321")
));

if ($result->isSuccess())
{
    $id = $result->getId();
    var_dump($id);
} else {
    $errors = $result->getErrors();
    
    foreach ($errors as $error)
    {
        // стандартные коды ошибок валидаторов BX_INVALID_VALUE BX_EMPTY_REQUIRED
        // типовые валидаторы
        // Entity\Validator\RegExp - проверка по регулярному выражению,
        // Entity\Validator\Length - проверка на минимальную/максимальную длину строки,
        // Entity\Validator\Range - проверка на минимальное/максимальное значение числа,
        // Entity\Validator\Unique - проверка на уникальность значения

        if ($error->getCode() == 'MY_ISBN_CHECKSUM')
        {
            echo '<br>сработал наш валидатор: '. $error->getMessage() . '<br>';
        } else {
            echo '<br>'. $error->getMessage() . '<br>';
        }
    }
}