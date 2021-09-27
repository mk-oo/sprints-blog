<?php
function getData($request,$name){
    if(isset($request[$name])){
        return $request[$name];
    }
    return '';
}