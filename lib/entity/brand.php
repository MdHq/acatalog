<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;

class BrandTable extends DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_brands';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('ID', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('NAME'),
            (new OneToMany(
                'MODELS',
                ModelTable::class,
                'BRAND')
            )->configureJoinType('inner')
        );
    }
}