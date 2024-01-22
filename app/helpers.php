<?php
// app/helpers.php

use App\Models\Language\Language;

function formatNumberCustom($number)
{
    return number_format($number, 2, ",", ".");
}
function displayRatingHtml($numberOfStars, $ratingValue){

    $output = "";
    for($i = 1; $i<=5; $i++){
        $class = "";
        if($i<=$numberOfStars) $class = "gold-star";
        $output .= '<i class="menu-icon tf-icons bx bxs-star '.$class.'"></i>';
    }
    $output .= ' <br> '.$ratingValue. 'x';
    echo $output;
}
function getTranslation($model, $property, $langCode)
{
    $translatedValue = $model->$property;
    if($model){
        if(isset($model->translation) && 
           array_key_exists($langCode, $model->translation) && 
           array_key_exists($property, $model->translation[$langCode])
           ){
            $translatedValue = $model->translation[$langCode][$property];
        }
    }
    echo $translatedValue;
}

function getAvailableLanguages(){
    $aryLanguages = Language::all();

    $ary = array();
    foreach($aryLanguages as $lang)
    $ary[] = array("code"=>$lang->code, "name"=>$lang->language, "exclude" => $lang->exclude);

    return $ary;
}
?>