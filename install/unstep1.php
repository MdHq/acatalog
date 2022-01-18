<form action="<?echo $APPLICATION->GetCurPage()?>">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?echo LANGUAGE_ID?>">
    <input type="hidden" name="id" value="acatalog">
    <input type="hidden" name="uninstall" value="Y">
    <input type="hidden" name="step" value="2">
    <?echo CAdminMessage::ShowMessage(GetMessage("MOD_UNINST_WARN"))?>
    <p><?echo GetMessage("MOD_UNINST_SAVE")?></p>
    <input type="radio" name="savedata" value="Y" checked>Да<br />
    <input type="radio" name="savedata" value="N">Нет<br />

    <input type="submit" name="inst" value="<?echo GetMessage("MOD_UNINST_DEL")?>">
</form>
