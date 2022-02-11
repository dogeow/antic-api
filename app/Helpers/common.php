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

/**
 * @param  string  $number  需要转换的字符串
 * @param  string  $targetBit  转成多少位
 * @return string
 */
function baseConvert(string $number, string $targetBit): string
{
    $dic = [
        0 => '0', 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9',
        10 => 'A', 11 => 'B', 12 => 'C', 13 => 'D', 14 => 'E', 15 => 'F', 16 => 'G', 17 => 'H', 18 => 'I',
        19 => 'J', 20 => 'K', 21 => 'L', 22 => 'M', 23 => 'N', 24 => 'O', 25 => 'P', 26 => 'Q', 27 => 'R',
        28 => 'S', 29 => 'T', 30 => 'U', 31 => 'V', 32 => 'W', 33 => 'X', 34 => 'Y', 35 => 'Z',
    ];
    $remainder = bcmod($number, $targetBit);
    $quotient = (string) floor((float) bcdiv($number, $targetBit));

    if ($quotient === "0") {
        return $dic[$remainder];
    }

    return baseConvert($quotient, $targetBit).$dic[$remainder];
}
