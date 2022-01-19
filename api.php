<?php
require_once
    $_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php";

if ($_SERVER["REQUEST_METHOD"] != "GET") {
    http_response_code(400);
    die(["error"=>"Only get requests is allowed."]);
}

$params = [];

//pagination
if (isset($_GET["pagesize"]) && is_numeric($_GET["pagesize"])) {
    if (!isset($_GET["page"])) {
        $_GET["page"] = 1;
    }

    $params["limit"] = $_GET["pagesize"];
    $params["offset"] = ($_GET["page"] - 1) * $_GET["pagesize"];
}

$params["select"] = [
    "*"
];

if (isset($_GET["brand"]) && is_array($_GET["brand"])) {
    $params["filter"]["BRAND_ID"] = $_GET["brand"];
}

if (isset($_GET["model"]) && is_array($_GET["model"])) {
    $params["filter"]["MODEL_ID"] = $_GET["model"];
}

if (isset($_GET["comp"]) && is_array($_GET["comp"])) {
    $params["filter"]["EQUIPMENT_ID"] = $_GET["comp"];
}

function convertBrand2Models(&$params)
{
    if (isset($params["filter"]["BRAND_ID"])) {
        $params2 = [
            "select" => ["ID"],
            "filter" => [
                "BRAND_ID" => $params["filter"]["BRAND_ID"]
            ]
        ];
        foreach (\AutoCatalog\ModelTable::getList($params2)->fetchAll() as $model) {
            if (!in_array($model["ID"], $params["filter"]["MODEL_ID"])) {
                $params["filter"]["MODEL_ID"][] = $model["ID"];
            }
        }
        unset($params["filter"]["BRAND_ID"]);
    }
}

function convertModel2Equipments(&$params)
{
    if (isset($params["filter"]["MODEL_ID"])) {
        $params2 = [
            "select" => ["ID"],
            "filter" => [
                "MODEL_ID" => $params["filter"]["MODEL_ID"]
            ]
        ];
        foreach (\AutoCatalog\EquipmentTable::getList($params2)->fetchAll() as $equips) {
            if (!in_array($equips["ID"], $params["filter"]["EQUIPMENT_ID"])) {
                $params["filter"]["EQUIPMENT_ID"][] = $equips["ID"];
            }
        }
        unset($params["filter"]["MODEL_ID"]);
    }
}

if (\Bitrix\Main\Loader::includeModule('acatalog')) {
    switch ($entity) {
        case "brands":
            $result = \AutoCatalog\BrandTable::getList($params)->fetchAll();
            break;
        case "models":
            $result = \AutoCatalog\ModelTable::getList($params)->fetchAll();
            break;
        case "comps":
            convertBrand2Models($params);
            $result = \AutoCatalog\EquipmentTable::getList($params)->fetchAll();
            break;
        case "cars":
            if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
                $car = \AutoCatalog\CarTable::getByPrimary($_GET["id"], ["select" => ["*", "OPTIONS", "EQUIPMENT"]])->fetchObject();
                $result = \AutoCatalog\CarTable::getByPrimary($_GET["id"])->fetch();
                $result["EQUIPMENT"] = \AutoCatalog\EquipmentTable::getByPrimary($result["EQUIPMENT_ID"])->fetch();
                $result["MODEL"] = \AutoCatalog\ModelTable::getByPrimary($result["EQUIPMENT"]["MODEL_ID"])->fetch();
                $result["BRAND"] = \AutoCatalog\BrandTable::getByPrimary($result["MODEL"]["BRAND_ID"])->fetch();
                $result["OPTIONS"]["CAR"] = [];
                $result["OPTIONS"]["EQUIPMENT"] = [];
                foreach ($car->getOptions() as $option) {
                    $result["OPTIONS"]["CAR"][$option["ID"]] = $option->getName();
                }
                $equip = \AutoCatalog\EquipmentTable::getByPrimary($car->getEquipment()->getId(), ["select" => ["*", "OPTIONS"]])->fetchObject();
                foreach ($equip->getOptions() as $option) {
                    $result["OPTIONS"]["EQUIPMENT"][$option["ID"]] = $option->getName();
                }
            } else {
                if (
                    isset($params["filter"]["BRAND_ID"]) &&
                    !isset($params["filter"]["MODEL_ID"]) &&
                    !isset($params["filter"]["EQUIPMENT_ID"])
                ) {
                    convertBrand2Models($params);
                }

                if (
                    isset($params["filter"]["MODEL_ID"]) &&
                    !isset($params["filter"]["EQUIPMEMT_ID"])
                ) {
                    unset($params["filter"]["BRAND_ID"]);
                    convertModel2Equipments($params);
                } else {
                    unset($params["filter"]["BRAND_ID"]);
                    unset($params["filter"]["MODEL_ID"]);
                }


                $result = \AutoCatalog\CarTable::getList($params)->fetchAll();
            }
            break;
    }
}

die(json_encode($result));