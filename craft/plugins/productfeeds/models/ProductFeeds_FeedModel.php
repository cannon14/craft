<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class ProductFeeds_FeedModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'name' => AttributeType::String,
            'url' => AttributeType::Url,
            'key' => AttributeType::String,
            'active' => AttributeType::Bool,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}