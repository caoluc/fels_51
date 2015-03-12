<?php

function url_ex($url)
{
    return url($url);
}

function getFormattedDate($datetime)
{
    return is_object($datetime) ? $datetime->format("Y-m-d") : "";
}

function imageWithSize($url, $width, $height)
{
    if (strpos($url, '?') === FALSE) {
        return $url . '?width=' . intval($width) . '&height=' . intval($height);
    } else {
        return $url . '&width=' . intval($width) . '&height=' . intval($height);
    }
}
