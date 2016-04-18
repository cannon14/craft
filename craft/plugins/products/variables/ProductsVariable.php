<?php
namespace Craft;


/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/20/16
 * Time: 2:55 PM
 */
class ProductsVariable
{
    private $cardService;
    private $prodCatMapService;
    private $topCardService;

    /**
     * ProductFeedsVariable constructor.
     */
    function __construct() {
        $this->cardService = new Products_CreditcardService();
        $this->prodCatMapService = new Products_ProductCategoryMapService();
        $this->topCardService = new Products_TopCardService();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getCard($id) {
        return $this->cardService->getCard($id);
    }

    /**
     * @param $page
     * @param $limit
     * @return static[]
     */
    public function getCards($page, $limit) {
        return $this->cardService->getCards($page, $limit);
    }

    /**
     * @param $id
     * @return static[]
     */
    public function getCardMappingsByCategoryId($id) {
        return $this->prodCatMapService->getCardMappingsByCategoryId($id);
    }

    /**
     * @param $id
     * @param $numOfCards
     * @return static
     */
    public function getCardsByCategoryId($id, $numOfCards) {
        return $this->topCardService->getCardsByCategoryId($id, $numOfCards);
    }
}