<?
use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

if(class_exists("mybookscatalog")) return;

Class mybookscatalog extends CModule
{
    var $MODULE_ID = "mybookscatalog";  // - хранит ID модуля (полный код партнерского модуля);
    var $MODULE_VERSION;            //- текущая версия модуля в формате XX.XX.XX;
    var $MODULE_VERSION_DATE;       //- строка содержащая дату версии модуля; дата должна быть задана в формате YYYY-MM-DD HH:MI:SS;
    var $MODULE_NAME;               // - имя модуля;
    var $MODULE_DESCRIPTION;        //- описание модуля;
    var $MODULE_CSS;                //
    var $MODULE_GROUP_RIGHTS = "Y"; //- если задан метод GetModuleRightList, то данное свойство должно содержать Y

    public function __construct()
    {
        $arModuleVersion = array();

        $path = str_replace("\\","/",__FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion["VERSION"];
        $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];

        $this->MODULE_NAME = GetMessage("MODULE_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("MODULE_DESC");
    }


    function InstallDB($install_wizard = true)
    {
        RegisterModule("mybookscatalog");
        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        global $DB;
        
        $arSql[] = "DROP TABLE my_book";

        foreach($arSql as $strSql)
        {
            if(!$DB->Query($strSql, true))
                $arSQLErrors[] = "<hr><pre>Query:\n".$strSql."\n\nError:\n<span style=\"color: red;\">".$DB->db_Error."</span></pre>";
        }

        UnRegisterModule("mybookscatalog");
        return true;
    }

    function InstallEvents()
    {
        return true;
    }

    function UnInstallEvents()
    {
        return true;
    }

    function InstallFiles()
    {
        return true;
    }

    function UnInstallFiles()
    {
        return true;
    }

    function DoInstall()
    {
        $this->InstallFiles();
        $this->InstallDB(false);
    }

    function DoUninstall()
    {
//        $this->UnInstallFiles();
        $this->UnInstallDB(false);
    }

    function GetModuleRightList()
    {
        global $MESS;
        $arr = array(
            "reference_id" => array("D","R","W"),
            "reference" => array(
                "[D] ".GetMessage("FORM_DENIED"),
                "[R] ".GetMessage("FORM_OPENED"),
                "[W] ".GetMessage("FORM_FULL"))
        );
        return $arr;
    }
}
?>