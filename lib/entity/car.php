<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class CarTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_cars';

    }

    public static function getMap()
    {
        return array(

            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME'),
            new Entity\IntegerField('YEAR'),
            new Entity\IntegerField('PRICE'),
            new Entity\IntegerField('EQUIPMENT_ID'),
            (new Reference(
                'EQUIPMENT',
                EquipmentTable::class,
                Join::on('this.EQUIPMENT_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('b_acatalog_car_options'),

        );
    }
}