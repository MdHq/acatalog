<?php
namespace AutoCatalog;

class Api
{
    static function getBrands($id=false){
//        if ($id && is_numeric($id)){
//            $brand = \AutoCatalog\BrandTable::getByPrimary(
//                $id,
//                ["select"=>[
//                    '*',
//                    'MODELS',
////                    'MODEL_'=>'MODELS'
//                ]])->fetchObject();
//            return $brand;
//        }else{
//            return NULL;
//        }
        $brands = BrandTable::getList(['select'=>["*"]])->fetchAll();
        return $brands;
    }
}