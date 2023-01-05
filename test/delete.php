<?php
use Bitrix\MyBooksCatalog\BookTable;

$id = 1;

$result = BookTable::delete($id);

if ($result->isSuccess())
{
   // success
} else {
    $errors = $result->getErrors();
    
    foreach ($errors as $error)
    {
        echo '<br>'. $error->getMessage() . '<br>';
    }
}