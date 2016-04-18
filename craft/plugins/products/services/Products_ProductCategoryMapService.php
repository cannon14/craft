<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Products_ProductCategoryMapService extends BaseApplicationComponent
{

    /**
     * @return static[]
     */
    public function getCardMappingsByCategoryId($id) {
        return Products_ProductCategoryMapRecord::model()
            ->findAllByAttributes(['category_id'=>$id], ['order' => 'rank asc',]);
    }

    /**
     * @return static[]
     */
    public function getCardIdByCategoryId($id) {
        return Products_ProductCategoryMapRecord::model()
            ->findByAttributes(['category_id'=>$id], ['order' => 'rank asc', 'limit' =>'1']);
    }
}