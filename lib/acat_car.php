<?php
namespace AutoCatalog;
class Car{
    private int $id;
    private string $name;
    private int $equipment_id;
    public Equipment $equipment;

    function __construct($id){
        if (is_numeric($id)) {
            global $DB;
            $sql = "SELECT * FROM b_acatalog_car WHERE id = '$id'";
            $objCars = $DB->Query($sql);
            if ($arCars = $objCars->Fetch()) {
                $this->name = $arCars["name"];
                $this->id = $arCars["id"];
                $this->equipment_id = $arCars["equipment"];
                $this->equipment = new Equipment($this->equipment_id);
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
        $sql = "SELECT * FROM b_acatalog_car";
        $objBrands = $DB->Query($sql);
        $result = [];
        while ($arBrands = $objBrands->Fetch()){
            $result[] = $arBrands;
        }
        return $result;
    }
}