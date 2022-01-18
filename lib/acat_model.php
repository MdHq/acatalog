<?php
namespace AutoCatalog;
class Model{
    private string $name;
    private int $id;
    private int $brand_id;
    public Brand $brand;

    function __construct($id){
        if (is_numeric($id)) {
            global $DB;
            $sql = "SELECT * FROM b_acatalog_model WHERE id = '$id'";
            $objModels = $DB->Query($sql);
            if ($arModels = $objModels->Fetch()) {
                $this->name = $arModels["name"];
                $this->id = $arModels["id"];
                $this->brand_id = $arModels["brand"];
                $this->brand = new Brand($this->brand_id);
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

    function getList(){
        global $DB;
        $sql = "SELECT * FROM b_acatalog_model";
        $objBrands = $DB->Query($sql);
        $result = [];
        while ($arBrands = $objBrands->Fetch()){
            $result[] = $arBrands;
        }
        return $result;
    }
}