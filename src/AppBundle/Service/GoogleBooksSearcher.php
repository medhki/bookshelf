<?php
/**
 * Created by PhpStorm.
 * User: moham
 * Date: 18/09/2018
 * Time: 11:23
 */

namespace AppBundle\Service;


class GoogleBooksSearcher
{
    public function removeNullInputs(array $searchedData){

        return array_filter($searchedData);
    }
    public function ApiLink(array $searchedData){
        $inputs= $this->removeNullInputs($searchedData);
        if ($inputs){
            $arr = [];
            foreach ($inputs as $key=>$input){
                $arr[]=$key.':'.urlencode($input);
            }
            return implode('+', $arr);
        }
        return null;
    }
    public function apiSearchResult(array $searchedData){
        $link = $this->ApiLink($searchedData);
        if ($link) {
            $response = file_get_contents("https://www.googleapis.com/books/v1/volumes?q=$link&maxResults=40&key=AIzaSyDN9k0zgC5BWUnEcQdg_qdeC2z2RiDG3Zw ");

            $data = json_decode($response, true);
            $items = $data['items']?? [];
        }else{
            $items = [];
        }
        return $items;
    }

}