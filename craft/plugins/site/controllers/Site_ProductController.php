<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Site_ProductController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionShowProduct() {

        $categoryId = craft()->request->getParam('catId');
        $cardId = craft()->request->getParam('cardId');

        $service = new Products_CreditcardService();

        $card = $service->getCard($cardId);

        $this->renderTemplate('product-detail-page', ['card'=>$card, 'categoryId'=>$categoryId]);
    }
}