<?php
namespace AutoCatalog;
class Equipment{
    private string $name;
    private int $id;
    private int $model_id;
    public Model $model;

    function __construct($id){
        if (is_numeric($id)) {
            global $DB;
            $sql = "SELECT * FROM b_acatalog_equipment WHERE id = '$id'";
            $objEquip = $DB->Query($sql);
            if ($arEquip = $objEquip->Fetch()) {
                $this->name = $arEquip["name"];
                $this->id = $arEquip["id"];
                $this->model_id = $arEquip["model"];
                $this->model = new Model($this->model_id);
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
        $sql = "SELECT * FROM b_acatalog_equipment";
        $objBrands = $DB->Query($sql);
        $result = [];
        while ($arBrands = $objBrands->Fetch()){
            $result[] = $arBrands;
        }
        return $result;
    }
}