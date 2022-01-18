<?php
namespace AutoCatalog;
class Brand{
    private string $name;
    private int $id;

    function __construct($id){
        if (is_numeric($id)) {
            global $DB;
            $sql = "SELECT * FROM b_acatalog_brands WHERE id = '$id'";
            $objBrands = $DB->Query($sql);
            if ($arBrands = $objBrands->Fetch()) {
                $this->name = $arBrands["name"];
                $this->id = $arBrands["id"];
            }
        }else{
            // ERROR
        }
    }

    public function get_id(){
        return $this->id;
    }

    public function get_name(){
        return $this->name;
    }

    static function getList(){
        global $DB;
        $sql = "SELECT * FROM b_acatalog_brands";
        $objBrands = $DB->Query($sql);
        $result = [];
        while ($arBrands = $objBrands->Fetch()){
            $result[] = $arBrands;
        }
        return $result;
    }
}