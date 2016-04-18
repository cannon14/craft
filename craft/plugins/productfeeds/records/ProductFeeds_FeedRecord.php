<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */
class ProductFeeds_FeedRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'feeds';
    }

    protected function defineAttributes()
    {
            return array(
                'name' => AttributeType::String,
                'url' => AttributeType::Url,
                'key' => AttributeType::String,
                'active' => AttributeType::Bool,
            );
    }

    public function defineIndexes()
    {
        return array(
            array('columns' => array('id'), 'unique' => true),
        );
    }
}