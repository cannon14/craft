<?php
namespace Craft;

/**
 * Created by PhpStorm.
 * User: david.cannon
 * Date: 3/15/16
 * Time: 7:35 PM
 */
class Curl_CurlService extends BaseApplicationComponent
{
    /**
     * Curl GET call
     * @param $url
     * @param $params
     * @param bool $toArray
     * @return mixed
     */
    public function get($url, $params, $toArray = false) {

        $params = $this->paramsToString($params);

        $curl = curl_init($url.$params);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response, $toArray);
    }


    public function post($url, $params, $array = false) {

    }

    /**
     * Convert key/value array to a url parameter string.
     * @param $params
     * @return string
     */
    public function paramsToString($params) {

        $str = '?';

        foreach($params as $key=>$value) {
            $str .= $key .'='.$value.'&';
        }

        return rtrim($str, '&');
    }
}