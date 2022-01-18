<?php
namespace AutoCatalog;

use Bitrix\Main\Entity;

class BrandTable extends Entity\DataManager
{
    public static function getTableName()
    {
        return 'b_acatalog_brands';
    }

    public static function getMap()
    {
        return array(
            new Entity\IntegerField('id', array(
                'primary' => true,
                'autocomplete' => true
            )),
            new Entity\StringField('name'),
//            new Entity\StringField('TITLE'),
//            new Entity\DateField('PUBLISH_DATE')
        );
    }
}