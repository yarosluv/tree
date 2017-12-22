<?php

$arr = [
    '55.100', //55.1
    '55.01', //55.01
    '55.001', //55.001
    '50.0010', //55.001
    '50.00'//55
];

function changeFormat(array $arr): array
{
    $res = [];
    foreach ($arr as $str) {
        if (!preg_match('%^[\d]+(\.[\d]+)?$%', $str)) {
            throw new \Exception('Bad format.');
        }
        $res[] = preg_replace('%(?(?=[\d+]\.[0]+))\.[0]+$|[0]+$%', '', $str);
    }

    return $res;
}

$res = changeFormat($arr);
var_dump($res);
