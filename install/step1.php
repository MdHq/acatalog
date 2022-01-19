<form action="<?= $APPLICATION->GetCurPage()?>" name="acatalog_install">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <input type="hidden" name="lang" value="<?= LANG ?>">
    <input type="hidden" name="id" value="acatalog">

    Удалить данные от прошлой установки?<br />
    <input type="radio" name="remove_old_data" value="Y" checked>Да<br />
    <input type="radio" name="remove_old_data" value="N">Нет<br />
    <br />
    <input type="submit" name="inst" value="<?= GetMessage("MOD_INSTALL")?>">
</form>
