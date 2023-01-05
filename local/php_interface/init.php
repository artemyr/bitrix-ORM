<?php
function dd($var) {
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die;
}

// можно подписаться на событие не только в нутри сущьности но у меня тут не получилось
// use Bitrix\Main\Loader;
// if (!Loader::includeModule('mybookscatalog')) return;
// $eventManager = Bitrix\Main\EventManager::getInstance();
// $st = $eventManager->addEventHandler(
//     "mybookscatalog",
//     "Bitrix\MyBooksCatalog\Book::onBeforeUpdate",
//     "bookOnBeforeUpdate"
// );
// // dd($st);
// function bookOnBeforeUpdate (\Bitrix\Main\Event $event) {
//     dd($event);
//     $result = new Entity\EventResult;
//     $data = $event->getParameter("fields");

//     if (isset($data['ISBN'])) // комплексная проверка данных
//     {
//         $result->addError(new Entity\EntityError(
//             'Невозможно обновить запись'
//         ));
//     }

//     return $result;
// }