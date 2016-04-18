<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Products_CreditcardService extends BaseApplicationComponent
{

    /**
     * @param null $page
     * @param null $limit
     * @return array
     */
    public function getCards($page=null, $limit=null) {

        $criteria['order'] = 'name asc';

        if(!is_null($page)) {
            $criteria['offset'] = $page;
        }

        if(!is_null($limit)) {
            $criteria['limit'] = $limit;
        }

        $cardRecords = Products_CreditcardRecord::model()->findAll($criteria);
        $cards = Products_CreditcardModel::populateModels($cardRecords, 'card_id');

        return $cards;
    }

    /**
     * @param $id
     * @return array|mixed|null
     */
    public function getCard($id) {
        // get record from DB
        return Products_CreditcardRecord::model()->findByAttributes(array('card_id' => $id));
    }

    public function update() {

        $id = craft()->request->getParam('card_id');
        $card = Products_CreditcardRecord::model()->findByAttributes(['card_id'=>$id]);

        if (!$card)
        {
            throw new Exception(Craft::t("No Creditcard exists with the ID “{id}”.", array('id' => $card->card_id)));
        }

        $card->card_id = craft()->request->getParam('card_id');
        $card->name = craft()->request->getParam('name');
        $card->link_url = craft()->request->getParam('link_url');
        $card->bullets = craft()->request->getParam('bullets');
        $card->image = craft()->request->getParam('image');
        $card->issuer_id = craft()->request->getParam('issuer_id');
        $card->issuer_name = craft()->request->getParam('issuer_name');
        $card->advertiser_id = craft()->request->getParam('advertiser_id');
        $card->advertiser_name = craft()->request->getParam('advertiser_name');
        $card->product_type_id = craft()->request->getParam('product_type_id');
        $card->network = craft()->request->getParam('network');
        $card->purchases_reg_apr_value = craft()->request->getParam('purchases_reg_apr_value');
        $card->purchases_reg_apr_display = craft()->request->getParam('purchases_reg_apr_display');
        $card->purchases_reg_apr_type = craft()->request->getParam('purchases_reg_apr_type');
        $card->purchases_reg_apr_min = craft()->request->getParam('purchases_reg_apr_min');
        $card->purchases_reg_apr_max = craft()->request->getParam('purchases_reg_apr_max');
        $card->purchases_intro_apr_value = craft()->request->getParam('purchases_intro_apr_value');
        $card->purchases_intro_apr_display = craft()->request->getParam('');
        $card->purchases_intro_apr_period_value = craft()->request->getParam('purchases_intro_apr_period_value');
        $card->purchases_intro_apr_period_min = craft()->request->getParam('purchases_intro_apr_period_min');
        $card->purchases_intro_apr_period_max = craft()->request->getParam('purchases_intro_apr_period_max');
        $card->purchases_intro_apr_period_end_date = craft()->request->getParam('purchases_intro_apr_period_end_date');
        $card->bt_reg_apr_value = craft()->request->getParam('bt_reg_apr_value');
        $card->bt_reg_apr_display = craft()->request->getParam('bt_reg_apr_display');
        $card->bt_intro_apr_value = craft()->request->getParam('bt_intro_apr_value');
        $card->bt_intro_apr_display = craft()->request->getParam('');
        $card->bt_intro_apr_period_value = craft()->request->getParam('bt_intro_apr_period_value');
        $card->bt_intro_apr_period_min = craft()->request->getParam('bt_intro_apr_period_min');
        $card->bt_intro_apr_period_max = craft()->request->getParam('bt_intro_apr_period_max');
        $card->bt_intro_apr_period_end_date = craft()->request->getParam('bt_intro_apr_period_end_date');
        $card->annual_fee_value = craft()->request->getParam('annual_fee_value');
        $card->annual_fee_display = craft()->request->getParam('annual_fee_display');
        $card->bt_annual_fee_display = craft()->request->getParam('bt_annual_fee_display');
        $card->activation_fee_value = craft()->request->getParam('activation_fee_value');
        $card->activation_fee_display = craft()->request->getParam('activation_fee_display');
        $card->atm_fee_value = craft()->request->getParam('atm_fee_value');
        $card->atm_fee_display = craft()->request->getParam('atm_fee_display');
        $card->pin_trans_fee_value = craft()->request->getParam('pin_trans_fee_value');
        $card->pin_trans_fee_display = craft()->request->getParam('signature_trans_fee_value');
        $card->signature_trans_fee_value = craft()->request->getParam('signature_trans_fee_value');
        $card->signature_trans_fee_display = craft()->request->getParam('signature_trans_fee_display');
        $card->load_fee_value = craft()->request->getParam('load_fee_value');
        $card->load_fee_display = craft()->request->getParam('load_fee_display');
        $card->credit_needed_value = craft()->request->getParam('credit_needed_value');
        $card->credit_needed_display = craft()->request->getParam('credit_needed_display');
        $card->review = craft()->request->getParam('review');
        $card->review_link = craft()->request->getParam('review_link');
        $card->review_overall_rating = craft()->request->getParam('review_overall_rating');
        $card->slug = craft()->request->getParam('slug');
        $card->active = craft()->request->getParam('active');

        return $card->update();

    }
}