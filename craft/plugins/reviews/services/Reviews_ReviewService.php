<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */

require __DIR__.'/../vendor/autoload.php';

use MongoDB;

/**
 * Class Reviews_ReviewService
 * @package Craft
 */
class Reviews_ReviewService extends BaseApplicationComponent
{
    private $client;
    private $collection;

    /**
     * Reviews_ReviewService constructor.
     */
    function __construct()
    {
        $this->client = new MongoDB\Client("mongodb://localhost:27017");
        $this->collection = $this->client->selectCollection('cccom', 'reviews');
    }

    /**
     * Parse file
     * @param $issuer
     * @param $file
     */
    public function parseFile($issuer, $file) {

        $file = fopen($file,"r");

        $headers = fgetcsv($file);

        while(!feof($file)) {
            $cells = fgetcsv($file);
            $row=[];
            $row['issuer']=$issuer;
            for($i = 0; $i < count($cells); $i++) {
                $row[$headers[$i]] = $cells[$i];
            }
            $exists = $this->collection->find(['Review ID'=>$row['Review ID']]);
            $data=$exists->toArray();
            if(!$data) {
                $status = $this->collection->insertOne($row);
            }
        }
        fclose($file);

    }

    /**
     * Get products by issuer
     * @param $issuerId
     * @return \mixed[]
     */
    public function getProductsByIssuer($issuerId) {

        $filter = [];
        if($issuerId != 'all') {
            $issuer = craft()->reviews_issuer->getIssuerById($issuerId);
            $filter['issuer'] = $issuer->name;
        }

        return $this->collection->distinct('Product Name', ['issuer'=>$issuer->name]);
    }

    /**
     * Get review count by issuer
     * @param $issuerName
     * @return int
     */
    public function getReviewCountByIssuer($issuerName) {
        return $this->collection->count(['Category'=>$issuerName]);
    }

    /**
     * Get review count
     *
     * @param array $filter
     * @return int
     */
    public function getReviewCount($filter=[]) {
        return $this->collection->count($filter);
    }

    /**
     * Disable reviews
     * @param array $filter
     * @return MongoDB\DeleteResult
     */
    public function disable(array $filter=[]) {
        $update = array(
            '$set' => array (
                'active' => 0
            )
        );
        return $this->collection->updateMany($filter, $update);
    }

    /**
     * Delete reviews
     * @param array $filter
     * @return MongoDB\DeleteResult
     */
    public function delete(array $filter=[]) {

        return $this->collection->deleteMany($filter);
    }

}