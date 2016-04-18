<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Products_TopCardController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionIndex()
    {
        $this->renderTemplate('');
    }

    public function actionEdit()
    {


    }

    public function actionUpdate()
    {
        $this->requirePostRequest();

    }
}