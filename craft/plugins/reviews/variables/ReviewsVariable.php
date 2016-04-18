<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/20/16
 * Time: 2:55 PM
 */

/**
 * Class ReviewsVariable
 * @package Craft
 */
class ReviewsVariable
{
    /**
     * Get/Paginate Issuers
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getIssuers($page, $limit) {

        return craft()->reviews_issuer->getIssuers($page, $limit);
    }

    /**
     * Get/Paginate Maps
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getMaps($page, $limit) {

        return craft()->reviews_idMap->getMaps($page, $limit);

    }

    /**
     * Get/Paginate Parsers
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getParsers($page, $limit) {

        return craft()->reviews_parser->getParsers($page, $limit);
    }
}