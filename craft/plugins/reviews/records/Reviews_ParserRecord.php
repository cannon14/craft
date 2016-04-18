<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */
class Reviews_ParserRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'reviews_parsers';
    }

    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'issuer_id' => AttributeType::Number,
            'description' => [AttributeType::String, 'column'=>ColumnType::Text],
            'columns' => [AttributeType::String, 'column' => ColumnType::Text],
            'active' => AttributeType::Bool
        );
    }

    public function defineIndexes()
    {
        return array(
            array('columns' => array('issuer_id'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
            'issuer' => array(static::BELONGS_TO, 'Reviews_IssuerRecord', 'issuer_id'),
        );
    }
}