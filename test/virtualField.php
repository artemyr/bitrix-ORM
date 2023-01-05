<?php
use Bitrix\MyBooksCatalog\BookTable;
use Bitrix\Main\Entity;


$book = BookTable::getList(array(
    'select' => array('*','AGE_DAYS'),
));

while ($row = $book->fetch())
{
    $rows[] = $row;
}

dd($rows);






$book = BookTable::getList(array(
    'select' => array(
        // 'MAX_AGE'
        new Entity\ExpressionField('MAX_AGE', 'MAX(%s)', array('AGE_DAYS'))
    ),
    // 'runtime' => array(
    //     new Entity\ExpressionField('MAX_AGE', 'MAX(%s)', array('AGE_DAYS'))
    // )
));

// dd($book);

while ($row = $book->fetch())
{
    $rows[] = $row;
}

dd($rows);