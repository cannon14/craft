<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Site_FeedService extends BaseApplicationComponent
{

    private $productFeedService;
    private $productService;
    private $curlService;

    function __construct()
    {
        $this->productFeedService = new ProductFeeds_FeedService();
        $this->productService = new Products_CreditcardService();
        $this->curlService = new Curl_CurlService();
    }

    /**
     * Pull Creditcards
     * @return array
     */
    public function pullCreditCardsFromFeed() {
        //Get the feed for products
        $feed = $this->productFeedService->getFeed(craft()->config->get('LINKOFFERS_PRODUCT_FEED_ID', 'productfeeds'));

        //Call curl plugin to get products
        $response = $this->curlService->get($feed->url, ['api_key'=>$feed->key]);

        //Response should have a data->products
        $cards = $response->data->products;

        $errors = [];

        foreach($cards as $card) {
            //Retrieve product if it already exists...for update
            $product = Products_CreditcardRecord::model()->findByAttributes(array('card_id' => $card->id));
            //If product does not exist...create one.
            if(!$product) {
                $product = new Products_CreditcardRecord();
            }

            $product->setAttribute('card_id', $card->id);
            !$this->isOverridden($product->name) ? $product->setAttribute('name', $card->name) : null;
            $product->setAttribute('issuer_id', $card->issuer_id->id);
            $product->setAttribute('issuer_name', $card->issuer_id->name);
            $product->setAttribute('link_url', $card->link_url);
            $product->setAttribute('bullets', $card->bullets);
            $product->setAttribute('image', $card->image);
            if(!is_null($card->advertiser)) {
                $product->setAttribute('advertiser_id', $card->advertiser->advertiser_id);
                $product->setAttribute('advertiser_name', $card->advertiser->name);
            }

            if(!is_null($card->product_type)) {
                $product->setAttribute('product_type_id', $card->product_type->id);
            }

            $product->setAttribute('network', $card->card_data->network);
            $product->setAttribute('image', $card->image);

            $short = $card->card_data->purchases->regular_apr;
            !$this->isOverridden($product->purchases_reg_apr_value) ? $product->setAttribute('purchases_reg_apr_value', $short->value) : null;
            !$this->isOverridden($product->purchases_reg_apr_display) ? $product->setAttribute('purchases_reg_apr_display', $short->display) : null;
            !$this->isOverridden($product->purchases_reg_apr_type) ? $product->setAttribute('purchases_reg_apr_type', $short->type) : null;
            !$this->isOverridden($product->purchases_reg_apr_min) ? $product->setAttribute('purchases_reg_apr_min', $short->min) : null;
            !$this->isOverridden($product->purchases_reg_apr_max) ? $product->setAttribute('purchases_reg_apr_max', $short->max) : null;

            $short = $card->card_data->purchases->intro_apr;
            !$this->isOverridden($product->purchases_intro_apr_value) ? $product->setAttribute('purchases_intro_apr_value', $short->value) : null;
            !$this->isOverridden($product->purchases_intro_apr_display) ? $product->setAttribute('purchases_intro_apr_display', $short->display) : null;
            !$this->isOverridden($product->purchases_intro_apr_period_value) ? $product->setAttribute('purchases_intro_apr_period_value', $short->period->value) : null;
            !$this->isOverridden($product->purchases_intro_apr_period_min) ? $product->setAttribute('purchases_intro_apr_period_min', $short->period->min) : null;
            !$this->isOverridden($product->purchases_intro_apr_period_max) ? $product->setAttribute('purchases_intro_apr_period_max', $short->period->max) : null;
            !$this->isOverridden($product->purchases_intro_apr_period_end_date) ? $product->setAttribute('purchases_intro_apr_period_end_date', $short->period->end_date) : null;

            $short = $card->card_data->balance_transfers->regular_apr;
            !$this->isOverridden($product->bt_reg_apr_value) ? $product->setAttribute('bt_reg_apr_value', $short->value) : null;
            !$this->isOverridden($product->bt_reg_apr_display) ? $product->setAttribute('bt_reg_apr_display', $short->display) : null;

            $short = $card->card_data->balance_transfers->intro_apr;
            !$this->isOverridden($product->bt_intro_apr_value) ? $product->setAttribute('bt_intro_apr_value', $short->value) : null;
            !$this->isOverridden($product->bt_intro_apr_display) ? $product->setAttribute('bt_intro_apr_display', $short->display) : null;
            !$this->isOverridden($product->bt_intro_apr_period_value) ? $product->setAttribute('bt_intro_apr_period_value', $short->period->value) : null;
            !$this->isOverridden($product->bt_intro_apr_period_min) ? $product->setAttribute('bt_intro_apr_period_min', $short->period->min) : null;
            !$this->isOverridden($product->bt_intro_apr_period_max) ? $product->setAttribute('bt_intro_apr_period_max', $short->period->max) : null;
            !$this->isOverridden($product->bt_intro_apr_period_end_date) ? $product->setAttribute('bt_intro_apr_period_end_date', $short->period->end_date) : null;

            $short = $card->card_data->fees;
            !$this->isOverridden($product->annual_fee_value) ? $product->setAttribute('annual_fee_value', $short->annual->value) : null;
            !$this->isOverridden($product->annual_fee_display) ? $product->setAttribute('annual_fee_display', $short->annual->display) : null;
            !$this->isOverridden($product->bt_annual_fee_display) ? $product->setAttribute('bt_annual_fee_display', $short->balance_transfer->display) : null;
            !$this->isOverridden($product->activation_fee_value) ? $product->setAttribute('activation_fee_value', $short->activation->value) : null;
            !$this->isOverridden($product->activation_fee_display) ? $product->setAttribute('activation_fee_display', $short->activation->display) : null;
            !$this->isOverridden($product->atm_fee_value) ? $product->setAttribute('atm_fee_value', $short->atm->value) : null;
            !$this->isOverridden($product->atm_fee_display) ? $product->setAttribute('atm_fee_display', $short->atm->display) : null;
            !$this->isOverridden($product->pin_trans_fee_value) ? $product->setAttribute('pin_trans_fee_value', $short->pin_transaction->value) : null;
            !$this->isOverridden($product->pin_trans_fee_display) ? $product->setAttribute('pin_trans_fee_display', $short->pin_transaction->display) : null;
            !$this->isOverridden($product->signature_trans_fee_value) ? $product->setAttribute('signature_trans_fee_value', $short->signature_transaction->value) : null;
            !$this->isOverridden($product->signature_trans_fee_display) ? $product->setAttribute('signature_trans_fee_display', $short->signature_transaction->display) : null;
            !$this->isOverridden($product->load_fee_value) ? $product->setAttribute('load_fee_value', $short->load->value) : null;
            !$this->isOverridden($product->load_fee_display) ? $product->setAttribute('load_fee_display', $short->load->display) : null;
            !$this->isOverridden($product->credit_needed_value) ? $product->setAttribute('credit_needed_value', $card->card_data->credit_needed->value) : null;
            !$this->isOverridden($product->credit_needed_display) ? $product->setAttribute('credit_needed_display', $card->card_data->credit_needed->display) : null;
            $product->setAttribute('last_updated_on_feed', $card->last_updated);
            $product->setAttribute('slug', $this->createSlug($card->name));
            $product->setAttribute('active', 1);

            $status = $product->save(false);

            if(!$status) {
                $errors[] = $product->getErrors();
            }
        }

        return $errors;
    }

    /**
     * Pull Creditcard Category Rankings
     * @return array
     */
    public function pullCreditcardsCategoriesFromFeed() {
        //Get the feed for products
        $feed = $this->productFeedService->getFeed(craft()->config->get('LINKOFFERS_CATEGORIES_FEED_ID', 'productfeeds'));

        //Call curl plugin to get products
        $response = $this->curlService->get($feed->url, ['api_key'=>$feed->key]);

        //Response should have a data->products
        $categories = $response->data->categories;

        $errors = [];

        //Delete all cards.
        Products_ProductCategoryMapRecord::model()->deleteAll();

        foreach($categories as $category) {

            $rankings = $category->rankings;

            foreach($rankings as $rank) {
                $record = new Products_ProductCategoryMapRecord();

                $record->setAttribute('category_id', $category->id);
                $record->setAttribute('card_id', $rank->product_id);
                $record->setAttribute('position_link', $rank->position_link);
                $record->setAttribute('rank', $rank->rank);

                $status = $record->save();
                $error = $record->getErrors();

                if(!$status) {
                    array_map($errors, $error);
                }
            }
        }
        return $errors;
    }

    /**
     * Convert a name into a slug.
     * @param $name
     * @return mixed|string
     */
    private function createSlug($name) {
        //Strip html tags
        $name = strip_tags($name);
        //Strip html entities
        $name = preg_replace("/&#?[a-z0-9]{2,8};/i","", $name);
        //Replace spaces with dashes
        $name = str_replace(' ', '-', $name);
        $name = str_replace('/','-', $name);
        //Convert to lowercase
        $name = strtolower($name);

        return $name;
    }

    /**
     * Check if string is prepended with '@@'
     * @param $value
     * @return bool
     */
    private function isOverridden($value) {
        return substr($value, 0, 2) == '@@';
    }

}