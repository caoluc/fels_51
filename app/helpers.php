<?php

function url_ex($url)
{
    return url($url);
}
function getFormattedDate($datetime)
{
    return is_object($datetime) ? $datetime->format("Y-m-d") : "";
}
