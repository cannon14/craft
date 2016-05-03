<?php
/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 4/30/16
 * Time: 10:15 AM
 */

namespace Craft;

/**
 * Class OfferClickController
 * @package Craft
 */
class OfferClick_OfferClickController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionOfferClick() {
        $this->requireAjaxRequest();

        $offerUrl = craft()->request->getRequiredParam('offerUrl');

        $this->redirect($offerUrl);
    }

}