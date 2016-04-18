<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Reviews_DashboardController extends BaseController
{
    protected $allowAnonymous = false;

    public function actionIndex()
    {
        $issuers = craft()->reviews_issuer->getIssuers();
        $this->renderTemplate('reviews/dashboard/index', ['issuers'=>$issuers]);
    }

    public function actionEdit()
    {


    }

    public function actionUpdate()
    {
        $this->requirePostRequest();

    }
}