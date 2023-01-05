<?php
use Bitrix\Main\Loader;

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if (!Loader::includeModule('mybookscatalog')) return;

// include("add.php");
include("update.php");
// include("delete.php");
// include("read.php");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");