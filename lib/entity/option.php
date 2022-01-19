<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;

class OptionTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_options';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME'),
            (new ManyToMany('EQUIPMENTS', EquipmentTable::class))
                ->configureTableName('b_acatalog_equipment_options'),
            (new ManyToMany('CARS', CarTable::class))
                ->configureTableName('b_acatalog_equipment_options'),
        );
    }
}