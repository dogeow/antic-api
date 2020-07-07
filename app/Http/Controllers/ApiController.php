<?php

namespace App\Http\Controllers;

use App\Models\Api;
use GuzzleHttp\Client as GuzzleClient;
use TrueBV\Punycode;

class ApiController extends Controller
{
    public $guzzleClient;

    public function index()
    {
        return Api::all();
    }

    public function number($start, $end, $action = null)
    {
        $count = strlen($end);
        $numberRange = range($start, $end);
        foreach ($numberRange as &$number) {
            if ($count > strlen($number)) {
                $zeroCount = $count - strlen($number);
                $number = str_repeat(0, $zeroCount).$number;
            }
        }

        $action === 'shuffle' && shuffle($numberRange);

        return $numberRange;
    }

    public function parking()
    {
        $parking = [
            21 => 558,
            20 => 217,
            19 => 345,
            18 => 211,
            17 => 76,
        ];
        $data = [];
        $this->guzzleClient = new GuzzleClient([
            'timeout' => 10,
        ]);
        $response = $this->guzzleClient->request('GET', 'https://www.cheboyi.com/wap/index/park22/14926');
        $html = $response->getBody()->getContents();

        foreach ($parking as $key => $item) {
            if (preg_match("/onclick='tc\(\"$item\".*?\)'/", $html, $match)) {
                $status = true;
            } else {
                $status = false;
            }
            $data[] = [
                'id' => $key,
                'status' => $status,
            ];
        }

        return $data;
    }

    public function punycode($domain)
    {
        $Punycode = new Punycode();
        $preg = "/[\x{4e00}-\x{9fa5}]+/u";
        if (preg_match_all($preg, $domain, $matches)) {
            var_dump($Punycode->encode($domain));
        } else {
            var_dump($Punycode->decode($domain));
        }
    }

    public function unicode_to_utf8($string)
    {
        $code = intval(hexdec($string));
        //这里注意转换出来的 code 一定得是整形，这样才会正确的按位操作
        $ord_1 = decbin(0xe0 | ($code >> 12));
        $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
        $ord_3 = decbin(0x80 | ($code & 0x3f));

        return chr(bindec($ord_1)).chr(bindec($ord_2)).chr(bindec($ord_3));
    }

    public function utf8_to_unicode($string)
    {
        $unicode = (ord($string[0]) & 0x1F) << 12;
        $unicode |= (ord($string[1]) & 0x3F) << 6;
        $unicode |= (ord($string[2]) & 0x3F);

        return '\u'.dechex($unicode);
    }

    /**
     * 随机获取一张图片作为登录背景.
     */
    public function random()
    {
        $wallpaperFolder = public_path().'/images/wallpaper/';
//        $wallpapers = \File::files($wallpaperFolder);

        $wallpapers = [
            'AIR.jpg',
            'LiveForSpeed.jpg',
            '你的名字.jpg',
            '塞尔达荒野之息.jpg',
            '守望先锋.jpg',
            '骑士.jpeg',
        ];

        $random = rand(0, count($wallpapers) - 1);
        $wallpaperURL = $wallpaperFolder.$wallpapers[$random];
//        $wallpaperURL = env('CDN_URL') . '/wallpaper/' . $wallpapers[$random];
        return response()->stream(function () use ($wallpaperURL) {
            echo file_get_contents($wallpaperURL);
        }, 200, ['Content-Type' => 'image/jpeg']);
    }

    public function base64_encode($string)
    {
        return base64_encode($string);
    }

    public function base64_decode($string)
    {
        return base64_decode($string);
    }

    public function urlEncode($string)
    {
        return urlencode($string);
    }

    public function urlDecode($string)
    {
        return urldecode($string);
    }

    public function image($action = null)
    {
        $uri = '/favicon.ico';
        switch ($action) {
            case 'url':
                return url($uri);
                break;
            case 'download':
                return response()->download(public_path($uri), '滑稽.ico');
                break;
            default:
                return;
        }
    }

    public function md5($string)
    {
        return md5($string);
    }

    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function array($string)
    {
        header('Access-Control-Allow-Origin:*');

        return [1, 2, 3, 4];
    }

    public function sha($string)
    {
        return sha1($string);
    }

    public function date($date = null)
    {
        return $date ? strtotime($date) : date('Y-m-d H:i:s', time());
    }

    public function timestamp($timestamp = null)
    {
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : time();
    }

    public function bankcard($cardNo)
    {
        return file_get_contents('https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo='.$cardNo.'&cardBinCheck=true');
    }

    public function secret($string)
    {
        return str_repeat('*', strlen($string));
    }

    public function hash($string)
    {
        return sha1($string);
    }

    public function htmlSC($string)
    {
        if ('&' === substr($string, 0, 1)) {
            return htmlspecialchars_decode($string);
        } else {
            return htmlspecialchars($string);
        }
    }

    public function ip($ip = null)
    {
        if ($ip ?? null) {
            $content = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);

            return response($content)->header('Content-Type', 'application/json');
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
}
