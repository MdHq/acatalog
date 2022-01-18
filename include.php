<?php
Bitrix\Main\Loader::registerAutoloadClasses(
    "acatalog",
    array(
        "\\AutoCatalog\\BrandTable" => 'lib/entity/brand.php',
        "\\AutoCatalog\\ModelTable" => 'lib/entity/model.php',
//        "\\AutoCatalog\\Equipment" => 'lib/acat_equipment.php',
//        "\\AutoCatalog\\Car" => 'lib/acat_car.php',
    )
);