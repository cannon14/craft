<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Site_CategoryService extends BaseApplicationComponent
{

    public function getCategoryBySlug($slug) {
        $record = CategoryRecord::model()->findByAttributes(['slug'=>$slug]);

        return $record;
    }

    public function getCategoryById($id) {
        $record = CategoryRecord::model()->findByAttributes(['category_id'=>$id]);

        return $record;
    }

}