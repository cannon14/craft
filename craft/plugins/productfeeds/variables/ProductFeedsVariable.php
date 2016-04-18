<?php
namespace Craft;

use Craft\ProductFeeds_FeedService;


/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/20/16
 * Time: 2:55 PM
 */
class ProductFeedsVariable
{
    private $service;

    /**
     * ProductFeedsVariable constructor.
     */
    function __construct() {
        $this->service = new ProductFeeds_FeedService();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getFeed($id) {
        return $this->service->getFeed($id);
    }

    /**
     * @return mixed
     */
    public function getFeeds() {
        return $this->service->getFeeds();
    }
}