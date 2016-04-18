<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:08 PM
 */
class Reviews_ReviewModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'id' => AttributeType::Number,
            'review_id' => AttributeType::String,
            'submission_date' => [AttributeType::DateTime, 'column'=>ColumnType::Date],
            'product_id' => AttributeType::String,
            'product_name' => AttributeType::String,
            'review_title' => AttributeType::String,
            'user_nickname' => AttributeType::String,
            'review_text' => [AttributeType::String, 'column' => ColumnType::Text],
            'overall_rating' => [AttributeType::Number, 'column'=>ColumnType::SmallInt],
            'online_experience' => [AttributeType::Number, 'column'=>ColumnType::SmallInt],
            'account_benefites' => [AttributeType::Number, 'column'=>ColumnType::SmallInt],
            'customer_service' => [AttributeType::Number, 'column'=>ColumnType::SmallInt],
            'rewards_program' => [AttributeType::Number, 'column'=>ColumnType::SmallInt],
            'recommend' => [AttributeType::String, 'column'=>ColumnType::Varchar, 'maxLength' => 50],
            'dateCreated' => AttributeType::DateTime,
            'dateUpdated' => AttributeType::DateTime,
        );
    }

}