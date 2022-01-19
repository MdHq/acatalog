<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Query\Join;

class ModelTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_models';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME'),
            new Entity\IntegerField("BRAND_ID"),
            (new Reference(
                'BRAND',
                BrandTable::class,
                Join::on('this.BRAND_ID', 'ref.ID')
            ))->configureJoinType('inner'),
            (new OneToMany(
                'EQUIPMENTS',
                EquipmentTable::class,
                'MODEL')
            )->configureJoinType('inner')
        );
    }
}