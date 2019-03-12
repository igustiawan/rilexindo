<?php

if ( ! function_exists('number_this')){
    function number_this($str, $align="right", $captionleft="", $captionright="", $decimal=0){
        if($str < 0){
            return '<div class="'.$align.'">( ' . $captionleft . number_format($str*-1,$decimal,'.',',') . $captionright . ' )</div>';
        }else{
            return '<div class="'.$align.'">' . $captionleft . number_format($str,$decimal,'.',',') . $captionright . '</div>';
        }
    }
}

if ( ! function_exists('format_number')){
    function format_number($str, $comma=2)
    {
        return number_format($str,$comma,'.',',');
    }
}

if ( ! function_exists('date_only')){
    function date_only($str){
        if($str == '' || empty($str)){
            return '';
        }else{
            return date('d M Y', strtotime($str));
        }
    }
}

if ( ! function_exists('datetime_only')){
    function datetime_only($str){
        if($str == '' || empty($str)){
            return '';
        }else{
            return date('d M Y H:i', strtotime($str));
        }
    }
}

if ( ! function_exists('time_only')){
    function time_only($str){
        if($str == '' || empty($str)){
            return '';
        }else{
            return date('H:i', strtotime($str));
        }
    }
}

if ( ! function_exists('number_only')){
    function number_only($str){
        if($str == '' || empty($str)){
            return '';
        }else{
            return (int)preg_replace('/[^\d]/', '', $str);
        }
    }
}

?>
