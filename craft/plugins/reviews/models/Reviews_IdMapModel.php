<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class Reviews_IdMapModel extends BaseModel
{

    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'name' => [AttributeType::String, 'required'=>true],
            'card_id' => [AttributeType::String, 'required'=>true],
            'alt_id' => [AttributeType::String, 'required'=>true],
            'active' => AttributeType::Bool,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}