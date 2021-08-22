<?php

/*
 *  Used to generate select option for multiselect
 *  @param
 *  $data as array of key & value pair
 *  @return select options
 */

function generateSelectOption($data){
    $options = array();
    foreach($data as $key => $value)
        $options[] = ['name' => $value, 'id' => $key];
    return $options;
}