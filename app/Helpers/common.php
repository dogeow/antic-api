<?php

function br2nl($input)
{
    return preg_replace('/<br\s?\/?>/iu', "\n",
        str_replace("\n", '', str_replace("\r", '', htmlspecialchars_decode($input))));
}

function getTitle($url)
{
    $str = file_get_contents($url);

    if ($str !== '') {
        $str = trim(preg_replace('/\s+/', ' ', $str));
        preg_match("/<title>(.*)<\/title>/i", $str, $title);

        return $title[1];
    }
}
