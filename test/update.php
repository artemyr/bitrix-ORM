<?php
use Bitrix\MyBooksCatalog\BookTable;
use Bitrix\Main\Type;
use Bitrix\Main\Entity;

$id = 3;

$result = BookTable::update($id, array(
    'PUBLISH_DATE' => new Type\Date('2004-11-15', 'Y-m-d'),
    'ISBN' => '9780321127429'
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