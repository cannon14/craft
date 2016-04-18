<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:38 PM
 */
class Site_CategoryController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionShowCategory() {

        $array = explode('/', $_SERVER['REQUEST_URI']);
        $slug = $array[1];

        $service = new Site_CategoryService();
        $category = $service->getCategoryBySlug($slug);

        $this->returnJson($category);
    }
}