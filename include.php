<?php
Bitrix\Main\Loader::registerAutoloadClasses(
    "acatalog",
    array(
        "\\AutoCatalog\\BrandTable"     => 'lib/entity/brand.php',
        "\\AutoCatalog\\ModelTable"     => 'lib/entity/model.php',
        "\\AutoCatalog\\EquipmentTable" => 'lib/entity/equipment.php',
        "\\AutoCatalog\\CarTable"       => 'lib/entity/car.php',
        "\\AutoCatalog\\OptionTable"    => 'lib/entity/option.php',
        "\\AutoCatalog\\Api"            => 'lib/Api.php'
    )
);