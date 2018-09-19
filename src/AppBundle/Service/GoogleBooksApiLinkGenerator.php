<?php
/**
 * Created by PhpStorm.
 * User: moham
 * Date: 18/09/2018
 * Time: 11:23
 */

namespace AppBundle\Service;


class GoogleBooksApiLinkGenerator
{
    public function removeNullInputs(array $searchedData){
        return array_filter($searchedData, function($input){return !is_null($input);} );
    }
    public function ApiLink(array $searchedData){
        $inputs= $this->removeNullInputs($searchedData);
        if ($inputs){
            $arr = [];
            foreach ($inputs as $key=>$input){
                $arr[]=$key.':'.$input;
            }
            return str_replace(" ","+",implode('+', $arr));
        }
        return ;
    }

}