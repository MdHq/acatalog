<?php
namespace AutoCatalog;
class Option{
    private string $name;
    private int $id;
    private int $attach_to;

    /**
     * @var int $type
     * 1 = attach to car
     * 2 = attach to equipment
     */
    private int $type;

    function __construct($id){
        global $DB;
        $sql = "SELECT * FROM b_acatalog_option WHERE id = '$id'";
        $objOption = $DB->Query($sql);
        if ($arOption = $objOption->Fetch()) {

        }
    }

//    function
}