<?php

function make_excerpt ($str , $len = 120 )
{
    $str = preg_replace('/\r\n|\r|\n+/', ' ' , strip_tags($str));

    return str_limit(trim($str) , $len);
}