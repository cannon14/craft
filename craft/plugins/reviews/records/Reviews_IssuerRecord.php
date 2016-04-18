<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */
class Reviews_IssuerRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'reviews_issuers';
    }

    protected function defineAttributes()
    {
        return array(
            'name' => AttributeType::String,
            'active' => [AttributeType::Bool, 'default'=>true]
        );
    }

    public function defineIndexes()
    {
        return array(
            array('columns' => array('name'), 'unique' => true),
        );
    }

    public function defineRelations()
    {
        return array(
        );
    }
}