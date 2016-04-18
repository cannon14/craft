<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */
class Products_ProductCategoryMapRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'product_category_map';
    }

    protected function defineAttributes()
    {
        return array(
            'category_id' => AttributeType::String,
            'card_id' => AttributeType::String,
            'position_link' => AttributeType::String,
            'rank' => AttributeType::Number,
        );
    }

    public function defineRelations()
    {
        return array(
            'cards' => array(static::HAS_MANY, 'Products_CreditcardRecord', 'card_id'),
        );
    }
}