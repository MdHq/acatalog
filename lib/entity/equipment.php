<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Relations\ManyToMany;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Query\Join;

class EquipmentTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_equipments';
    }

    public static function getMap()
    {
        return array(

            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME'),
            new Entity\IntegerField("MODEL_ID"),
            (new Reference(
                'MODEL',
                ModelTable::class,
                Join::on('this.MODEL_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new OneToMany(
                'CARS',
                CarTable::class,
                'EQUIPMENT')
            )->configureJoinType('inner'),
            (new ManyToMany('OPTIONS', OptionTable::class))
                ->configureTableName('b_acatalog_equipment_options'),
        );
    }
}