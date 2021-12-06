<?php

declare(strict_types=1);

function br2nl($input)
{
    return preg_replace(
        '/<br\s?\/?>/iu',
        "\n",
        str_replace("\n", '', str_replace("\r", '', htmlspecialchars_decode($input)))
    );
}

function getTitle($url)
{
    $str = file_get_contents($url);

    if ($str !== '') {
        $str = trim(preg_replace('/\s+/', ' ', $str));
        preg_match("/<title>(.*)<\/title>/i", $str, $title);

        return $title[1];
    }

    return false;
}

/**
 * 获取一张图片的主要颜色
 *
 * @param  string  $imgUrl  图片的本地路径或者在线路径
 * @param  bool  $isHex  是否获取16进制的主要颜色
 */
function getMainColor(string $imgUrl, bool $isHex): string
{
    $imageInfo = getimagesize($imgUrl);
    // 图片类型
    $imgType = strtolower(substr(image_type_to_extension($imageInfo[2]), 1));
    // 对应函数
    $imageFun = 'imagecreatefrom'.($imgType === 'jpg' ? 'jpeg' : $imgType);
    $i = $imageFun($imgUrl);
    // 循环色值
    $rColorNum = $gColorNum = $bColorNum = $total = 0;
    for ($x = 0; $x < imagesx($i); $x++) {
        for ($y = 0; $y < imagesy($i); $y++) {
            $rgb = imagecolorat($i, $x, $y);
            // 三通道
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            $rColorNum += $r;
            $gColorNum += $g;
            $bColorNum += $b;
            $total++;
        }
    }
    $r = round($rColorNum / $total);
    $g = round($gColorNum / $total);
    $b = round($bColorNum / $total);
    if ($isHex) {
        return rgb2Hex($r, $g, $b);
    }

    return "rgb(${r}, ${g}, ${b})";
}

/**
 * RGB颜色转16进制颜色
 */
function rgb2Hex(array|int $r, int $g = -1, int $b = -1): string
{
    if (is_array($r) && count($r) === 3) {
        [$r, $g, $b] = $r;
    }
    $r = (int) $r;
    $g = (int) $g;
    $b = (int) $b;
    $r = dechex($r < 0 ? 0 : ($r > 255 ? 255 : $r));
    $g = dechex($g < 0 ? 0 : ($g > 255 ? 255 : $g));
    $b = dechex($b < 0 ? 0 : ($b > 255 ? 255 : $b));
    $color = (strlen($r) < 2 ? '0' : '').$r;
    $color .= (strlen($g) < 2 ? '0' : '').$g;
    $color .= (strlen($b) < 2 ? '0' : '').$b;

    return "#${color}";
}
