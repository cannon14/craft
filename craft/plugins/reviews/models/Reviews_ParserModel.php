<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class Reviews_ParserModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'name' => AttributeType::String,
            'issuer_id' => AttributeType::Number,
            'description' => [AttributeType::String, 'column'=>ColumnType::Text],
            'columns' => [AttributeType::String, 'column' => ColumnType::Text],
            'active' => AttributeType::Bool,
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime
        );
    }

}