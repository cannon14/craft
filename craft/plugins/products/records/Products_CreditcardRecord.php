<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:23 PM
 */
class Products_CreditcardRecord extends BaseRecord
{

    public function getTableName()
    {
        return 'products';
    }

    protected function defineAttributes()
    {
        return array(
            'card_id' => AttributeType::String,
            'name' => AttributeType::String,
            'link_url' => AttributeType::Url,
            'bullets' => [AttributeType::String, 'column' => ColumnType::Text],
            'image' => AttributeType::String,
            'issuer_id' => AttributeType::String,
            'issuer_name' => AttributeType::String,
            'advertiser_id' => AttributeType::String,
            'advertiser_name' => AttributeType::String,
            'product_type_id' => AttributeType::String,
            'network' => AttributeType::String,
            'purchases_reg_apr_value' => AttributeType::String,
            'purchases_reg_apr_display' => AttributeType::String,
            'purchases_reg_apr_type' => AttributeType::String,
            'purchases_reg_apr_min' => AttributeType::String,
            'purchases_reg_apr_max' => AttributeType::String,
            'purchases_intro_apr_value' => AttributeType::String,
            'purchases_intro_apr_display' => AttributeType::String,
            'purchases_intro_apr_period_value' => AttributeType::String,
            'purchases_intro_apr_period_min' => AttributeType::String,
            'purchases_intro_apr_period_max' => AttributeType::String,
            'purchases_intro_apr_period_end_date' => [AttributeType::String, 'default' => '0000-00-00 00:00:00'],
            'bt_reg_apr_value' => AttributeType::String,
            'bt_reg_apr_display' => AttributeType::String,
            'bt_intro_apr_value' => AttributeType::String,
            'bt_intro_apr_display' => AttributeType::String,
            'bt_intro_apr_period_value' => AttributeType::String,
            'bt_intro_apr_period_min' => AttributeType::String,
            'bt_intro_apr_period_max' => AttributeType::String,
            'bt_intro_apr_period_end_date' => [AttributeType::String, 'default' => '0000-00-00 00:00:00'],
            'annual_fee_value' => AttributeType::String,
            'annual_fee_display' => AttributeType::String,
            'bt_annual_fee_display' => AttributeType::String,
            'activation_fee_value' => AttributeType::String,
            'activation_fee_display' => AttributeType::String,
            'atm_fee_value' => AttributeType::String,
            'atm_fee_display' => AttributeType::String,
            'pin_trans_fee_value' => AttributeType::String,
            'pin_trans_fee_display' => AttributeType::String,
            'signature_trans_fee_value' => AttributeType::String,
            'signature_trans_fee_display' => AttributeType::String,
            'load_fee_value' => AttributeType::String,
            'load_fee_display' => AttributeType::String,
            'credit_needed_value' => AttributeType::String,
            'credit_needed_display' => AttributeType::String,
            'review' => [AttributeType::String, 'column' => ColumnType::Text],
            'review_link' => AttributeType::String,
            'review_overall_rating' => [AttributeType::Number, 'column' => ColumnType::Decimal],
            'last_updated_on_feed' => AttributeType::DateTime,
            'slug' => AttributeType::Slug,
            'active' => [AttributeType::Bool, 'default'=>1]
        );
    }

    public function defineIndexes()
    {
        return array(
            array('columns' => array('card_id'), 'unique' => true),
        );
    }
}