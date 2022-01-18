<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

class ModelTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_model';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('name'),
            new Entity\IntegerField("brand_id"),
            new Reference(
                'brand',
                BrandTable::class,
                Join::on('this.brand_id', 'ref.ID')
            )
//            new Entity\StringField('TITLE'),
//            new Entity\DateField('PUBLISH_DATE')
        );
    }
}