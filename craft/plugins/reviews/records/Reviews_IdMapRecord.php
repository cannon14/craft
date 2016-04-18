<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */

/**
 * Class Reviews_IdMapRecord
 * @package Craft
 */
class Reviews_IdMapRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'reviews_id_map';
    }

    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'card_id' => AttributeType::String,
            'alt_id' => AttributeType::String,
            'active' => AttributeType::Bool,
        );
    }

    public function defineIndexes()
    {
        return array(
            array('columns' => array('card_id'), 'unique' => true),
            array('columns' => array('alt_id'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
        );
    }
}