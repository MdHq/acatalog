<?
global $MESS;
$strPath2Lang = str_replace("\\", "/", __FILE__);
$strPath2Lang = substr($strPath2Lang, 0, strlen($strPath2Lang)-strlen("/install/index.php"));
include(GetLangFileName($strPath2Lang."/lang/", "/install/index.php"));

Class acatalog extends CModule
{
    var $MODULE_ID = "acatalog";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_CSS;
    var $MODULE_GROUP_RIGHTS = "Y";

    function acatalog()
    {
        $arModuleVersion = array();

        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");

        if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
        {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }
        else
        {
            $this->MODULE_VERSION = ACATALOG_VERSION;
            $this->MODULE_VERSION_DATE = ACATALOG_VERSION_DATE;
        }

        $this->MODULE_NAME = GetMessage("ACATALOG_INSTALL_NAME");
        $this->MODULE_DESCRIPTION = GetMessage("ACATALOG_INSTALL_DESCRIPTION");
    }

    function InstallDB($install_wizard = true)
    {
        global $DB, $DBType, $APPLICATION, $install_smiles;

//        $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/".$DBType."/install.sql");
//        $DB->Query();
//
//        if (!$DB->Query("SELECT 'x' FROM b_acatalog_brands", true))
//        {
////            $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/".$DBType."/install.sql");
////            COption::SetOptionString("blog", "socNetNewPerms", "Y");
//        }

        if (empty($errors))
        {
//            $errors = $this->InstallUserFields();
        }

        if (!empty($errors))
        {
            $APPLICATION->ThrowException(implode("", $errors));
            return false;
        }

        RegisterModule("acatalog");

//        $eventManager = \Bitrix\Main\EventManager::getInstance();
//        $eventManager->registerEventHandler('mail', 'onReplyReceivedBLOG_POST', 'blog', '\Bitrix\Blog\Internals\MailHandler', 'handleReplyReceivedBlogPost');
//        $eventManager->registerEventHandler('mail', 'onForwardReceivedBLOG_POST', 'blog', '\Bitrix\Blog\Internals\MailHandler', 'handleForwardReceivedBlogPost');

//        CModule::IncludeModule("acatalog");

        return true;
    }

    function UnInstallDB($arParams = Array())
    {
        global $DB, $DBType, $APPLICATION;
//        if(array_key_exists("savedata", $arParams) && $arParams["savedata"] != "Y")
//        {
////            $errors = $DB->RunSQLBatch($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/".$DBType."/uninstall.sql");
//
//            if (!empty($errors))
//            {
//                $APPLICATION->ThrowException(implode("", $errors));
//                return false;
//            }
//        }

        UnRegisterModule("acatalog");

        return true;
    }

    function InstallFiles()
    {
        global $install_public, $public_rewrite, $public_dir;
        if($_ENV["COMPUTERNAME"]!='BX')
        {
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/admin", $_SERVER["DOCUMENT_ROOT"]."/local/admin", true);
//            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/blog/install/images",  $_SERVER["DOCUMENT_ROOT"]."/bitrix/images/blog", true, True);
//            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/blog/install/themes", $_SERVER["DOCUMENT_ROOT"]."/bitrix/themes", true, true);
            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/components", $_SERVER["DOCUMENT_ROOT"]."/local/components", true, true);
//            CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/blog/install/public/templates", $_SERVER["DOCUMENT_ROOT"]."/bitrix/templates", true, true);
        }

        $install_public = (($install_public == "Y") ? "Y" : "N");
        $errors = false;

        $arSite = Array();
        $public_installed = false;
        $dbSites = CSite::GetList(($b = ""), ($o = ""), Array("ACTIVE" => "Y"));
        while ($site = $dbSites->Fetch())
        {
            $arSite[] = Array(
                "LANGUAGE_ID" => $site["LANGUAGE_ID"],
                "ABS_DOC_ROOT" => $site["ABS_DOC_ROOT"],
                "DIR" => $site["DIR"],
                "SITE_ID" => $site["LID"],
                "SERVER_NAME" =>$site["SERVER_NAME"],
                "NAME" => $site["NAME"]
            );
        }

        foreach($arSite as $fSite)
        {
            global ${"install_public_".$fSite["SITE_ID"]};
            global ${"public_path_".$fSite["SITE_ID"]};
            global ${"public_rewrite_".$fSite["SITE_ID"]};
            global ${"is404_".$fSite["SITE_ID"]};

            if (${"install_public_".$fSite["SITE_ID"]} == "Y" && !empty(${"public_path_".$fSite["SITE_ID"]}))
            {
                $public_dir = ${"public_path_".$fSite["SITE_ID"]};
                $bReWritePublicFiles = ${"public_rewrite_".$fSite["SITE_ID"]};
                $folder = (${"is404_".$fSite["SITE_ID"]}=="Y")?"SEF":"NSEF";

//                CopyDirFiles($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/blog/install/public/".$folder, $fSite['ABS_DOC_ROOT'].$fSite["DIR"].$public_dir, $bReWritePublicFiles, true);
                if ($folder == "SEF")
                {
                    $arFields = array(
                        "CONDITION" => "#^/".$public_dir."/#",
                        "RULE" => "",
                        "ID" => "bitrix:acatalog",
                        "PATH" => "/".$public_dir."/index.php"
                    );
                    CUrlRewriter::Add($arFields);
                }
                $public_installed = true;
            }
        }
        return true;
    }

    function UnInstallFiles()
    {
        if($_ENV["COMPUTERNAME"]!='BX')
        {
            DeleteDirFiles($_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/admin", $_SERVER["DOCUMENT_ROOT"]."/local/admin");
        }

        return true;
    }

    function DoInstall()
    {
        global $APPLICATION, $step;
        $step = IntVal($step);
        if ($step < 2)
            $APPLICATION->IncludeAdminFile(GetMessage("ACATALOG_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/step1.php");
        elseif($step==2)
        {
            $this->InstallFiles();
            $this->InstallDB(false);
            $GLOBALS["errors"] = $this->errors;

            $APPLICATION->IncludeAdminFile(GetMessage("ACATALOG_INSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/step2.php");
        }
    }

    function DoUninstall()
    {
        global $APPLICATION, $step;
        $step = IntVal($step);
        if($step<2)
            $APPLICATION->IncludeAdminFile(GetMessage("ACATALOG_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/unstep1.php");
        elseif($step==2)
        {
            $this->UnInstallDB(array(
                "savedata" => $_REQUEST["savedata"],
            ));
            $this->UnInstallFiles();

            $GLOBALS["errors"] = $this->errors;

            $APPLICATION->IncludeAdminFile(GetMessage("ACATALOG_UNINSTALL_TITLE"), $_SERVER["DOCUMENT_ROOT"]."/local/modules/acatalog/install/unstep2.php");
        }
    }

    function GetModuleRightList()
    {
        $arr = array(
            "reference_id" => array("D", /*"K",*/ "N", "R", "W"),
            "reference" => array(
                "[D] ".GetMessage("BLI_PERM_D"),
                //"[K] ".GetMessage("BLI_PERM_K"),
                "[N] ".GetMessage("BLI_PERM_N"),
                "[R] ".GetMessage("BLI_PERM_R"),
                "[W] ".GetMessage("BLI_PERM_W")
            )
        );
        return $arr;
    }
}
?>