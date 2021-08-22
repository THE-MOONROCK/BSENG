<?php

/**
 * Trait used for common functions
 */
namespace App\Traits;

use Illuminate\Support\Facades\Request;

trait HelperTrait {

    private function getChild($child){
        $children = [];
        foreach ($child as $value){
            if($value->children && sizeof($value->children) > 0){
                foreach ($value->children as $row){
                    $children[] = $row->id;
                }
            }
        }
        return $children;
    }

    public function proceedWithInstallation($data){
        $url = "https://scriptmint.com/api/v1/purchase/verification";
        $postData = array(
            'product_code' => '870303',
            'url' => Request::url(),
            'license' => $data['license'],
            'email' => $data['email']
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response,true);
    }

    public function checkIfRequestValid($key) {
        if (!$key) return false;
        if (!request()->has($key)) return false;
        $value = request($key);
        if (!$value || $value == '') return false;
        if (!isset($value)) return false;
        return true;
    }

    public function getValueFromRequest($key, $default = null) {
        if ($this->checkIfRequestValid($key)) {
            return request($key);
        }
        if ($this->checkIfRequestValid(strtolower($key))) {
            return request(strtolower($key));
        }
        return $default ? $default : null;
    }

    public function queryDefaultSort($list) {
        $sortBy = $this->getValueFromRequest('sortBy', 'created_at');
        $sortOrder = $this->getValueFromRequest('order', 'desc');
        return $list->orderBy($sortBy, $sortOrder);
    }
}