<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class Products_ProductCategoryMapModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'category_id' => AttributeType::String,
            'card_id' => AttributeType::String,
            'position_link' => AttributeType::String,
            'rank' => AttributeType::Number,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}