<?php

/**
 * 给定开始字符和结束字符，截取这个区间
 */
function getStringBetween(string $string, string $start, string $end): string
{
    $startPos = strpos($string, $start);
    $endPos = strpos($string, $end);

    return substr($string, $startPos, $endPos - $startPos);
}
