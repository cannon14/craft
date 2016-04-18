<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class Reviews_IssuerModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'name' => AttributeType::String,
            'active' => [AttributeType::Bool, 'default'=>true],
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}