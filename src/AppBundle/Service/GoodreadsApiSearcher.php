<?php
/**
 * Created by PhpStorm.
 * User: moham
 * Date: 18/09/2018
 * Time: 11:23
 */

namespace AppBundle\Service;


class GoodreadsApiSearcher
{

    public function apiSearchResult($field , $searched ){
        $response = file_get_contents("https://www.goodreads.com/search/index.xml?key=i5iwbTZeWk19L046TRZFRg&q=$searched&search[field]=$field ");
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $data = json_decode($json,TRUE);
        $items =$data['search']['results']['work']?? [];
        return $items;
    }

}