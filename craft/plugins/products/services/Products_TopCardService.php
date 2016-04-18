<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Products_TopCardService extends BaseApplicationComponent
{

    /**
     * @param $id
     * @param $numOfCards
     * @return static
     */
    public function getCardsByCategoryId($id, $numOfCards) {
        $maps = Products_ProductCategoryMapRecord::model()
            ->findAllByAttributes(['category_id'=>$id], ['order'=> 'rank ASC', 'limit'=>$numOfCards]);

        $cards = [];
        foreach($maps as $map) {
            $cards[] = Products_CreditcardRecord::model()
                ->findByAttributes(['card_id' => $map->card_id]);
        }

        return $cards;

    }
}