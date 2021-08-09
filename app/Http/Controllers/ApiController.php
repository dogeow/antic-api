<?php

namespace App\Http\Controllers;

use App\Models\Api;
use Exception;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use TrueBV\Punycode;

class ApiController extends Controller
{
    private GuzzleClient $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'timeout' => 10,
        ]);
    }

    /**
     * @throws Exception
     */
    public function random()
    {
        $wallpapers = [
            'AIR.jpg',
            'LiveForSpeed.jpg',
            '你的名字.jpg',
            '塞尔达荒野之息.jpg',
            '守望先锋.jpg',
            '骑士.jpeg',
        ];

        $random = random_int(0, count($wallpapers) - 1);

        return redirect('https://oss.dogeow.com/wallpaper/'.$wallpapers[$random]);
    }

    public function index(): Collection|array
    {
        return Api::all();
    }

    /**
     * 返回第三方支付或美团外卖等的回调信息
     * @param  Request  $request
     * @return JsonResponse
     */
    public function callback(Request $request): JsonResponse
    {
        \Log::info(var_export($request->all(), true));
        $config = config('services.meituan');
        $callbackCount = \Cache::get('meituan');
        $returnData = $callbackCount <= 3 ? $config['error'] : $config['success'];
        \Cache::increment('meituan');

        return response()->json($returnData);
    }

    public function number($start, $end, $action = null): array
    {
        $count = strlen($end);
        $numberRange = range($start, $end);
        foreach ($numberRange as &$number) {
            if ($count > strlen($number)) {
                $zeroCount = $count - strlen($number);
                $number = str_repeat('0', $zeroCount).$number;
            }
        }
        unset($number);

        $action === 'shuffle' && shuffle($numberRange);

        return $numberRange;
    }

    public function parking(): array
    {
        $parking = [
            17 => 76,
            18 => 211,
            19 => 345,
            20 => 217,
            21 => 558,
        ];
        $data = [];
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

    public function punycode($domain = ''): string
    {
        $Punycode = new Punycode();
        $preg = "/[\x{4e00}-\x{9fa5}]+/u";
        if (preg_match_all($preg, $domain, $matches)) {
            return $Punycode->encode($domain);
        }

        return $domain;
    }

    public function unicode_to_utf8($string): string
    {
        $code = (int) hexdec($string);
        // 这里注意转换出来的 code 一定得是整形，这样才会正确的按位操作
        $ord_1 = decbin(0xe0 | ($code >> 12));
        $ord_2 = decbin(0x80 | (($code >> 6) & 0x3f));
        $ord_3 = decbin(0x80 | ($code & 0x3f));

        return chr(bindec($ord_1)).chr(bindec($ord_2)).chr(bindec($ord_3));
    }

    public function utf8_to_unicode($string): string
    {
        $unicode = (ord($string[0]) & 0x1F) << 12;
        $unicode |= (ord($string[1]) & 0x3F) << 6;
        $unicode |= (ord($string[2]) & 0x3F);

        return '\u'.dechex($unicode);
    }

    public function base64_encode($string = ''): string
    {
        return base64_encode($string);
    }

    public function base64_decode($string = '')
    {
        return base64_decode($string);
    }

    public function urlEncode($string = ''): string
    {
        return urlencode($string);
    }

    public function urlDecode($string = ''): string
    {
        return urldecode($string);
    }

    public function image($action = null): BinaryFileResponse|string|UrlGenerator|Application
    {
        $uri = '/favicon.ico';
        switch ($action) {
            case 'url':
                return url($uri);
            case 'download':
                return response()->download(public_path($uri), '滑稽.ico');
        }
    }

    public function md5($string = ''): string
    {
        return md5($string);
    }

    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function sha($string): string
    {
        return sha1($string);
    }

    public function date($date = null): bool|int|string
    {
        return $date ? strtotime($date) : date('Y-m-d H:i:s');
    }

    public function timestamp($timestamp = null): bool|int|string
    {
        return $timestamp ? date('Y-m-d H:i:s', $timestamp) : time();
    }

    public function bankcard($cardNo): bool|string
    {
        return file_get_contents('https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo='.$cardNo.'&cardBinCheck=true');
    }

    public function secret($string = ''): string
    {
        return str_repeat('*', strlen($string));
    }

    public function hash($string = ''): string
    {
        return sha1($string);
    }

    public function htmlSC($string): string
    {
        if (str_starts_with($string, '&')) {
            return htmlspecialchars_decode($string);
        }

        return htmlspecialchars($string);
    }

    public function ip($ip = null)
    {
        if ($ip) {
            $content = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$ip);

            return response($content)->header('Content-Type', 'application/json');
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    public function howTime($content)
    {
        return date('Y-m-d', strtotime($content));
    }

    public function sp($content): string
    {
        return Str::singular($content) === $content ? Str::plural($content) : Str::singular($content);
    }

    public function getTitle(Request $request): array|string
    {
        $title = '';
        $charset = 'UTF-8';

        try {
            $response = $this->guzzleClient->request('GET', $request->input('url'));
            $html = $response->getBody()->getContents();
            if (preg_match('/charset=(.*?)[">]]/i', $html, $matches)) {
                $charset = $matches[1];
            }
            $body = mb_convert_encoding($html, 'UTF-8', $charset ?: 'UTF-8');
            $str = trim(preg_replace('/\s+/', ' ', $body));
            if (preg_match("/<title>(.*?)<\/title>/i", $str, $title)) {
                $title = $title[1];
            }
        } catch (Exception  $e) {
            return $e->getMessage(); // todo
        }

        return [
            'title' => $title,
        ];
    }

    /**
     * @param  Request  $request
     * @return string
     */
    public function mediawikiToMarkdown(Request $request): string
    {
        $mediawiki = $request->input('mediawiki');

        $contentArray = explode(PHP_EOL, $mediawiki);
        $maxLine = count($contentArray);

        $markdown = '';

        foreach ($contentArray as $line => $string) {
            if (strlen($string) > 2 && $string[0] === '*' && in_array($string[1], ['*', ' '], true) === false) {
                $string = $string[0].' '.substr($string, 1);
            }

            // 替换 code
            $string = str_replace(['<code>', '</code>'], '`', $string);

            // 替换 pre
            if ($string === "<pre>") {
                if ($line !== 0 && trim($contentArray[$line - 1]) !== ''){
                    $string = str_replace('<pre>', PHP_EOL.'```shell', $string);
                } else {
                    $string = str_replace('<pre>', '```shell', $string);
                }
            }

            if (isset($contentArray[$line + 1]) && trim($contentArray[$line + 1]) !== '') {
                $string = str_replace('<pre>', PHP_EOL."```shell\n", $string);
            } else {
                $string = str_replace('<pre>', "```shell\n", $string);
            }

            if ($string === "</pre>") {
                if ($line !== $maxLine - 1 && trim($contentArray[$line + 1]) !== '') {
                    $string = str_replace('</pre>', "```".PHP_EOL, $string);
                } else {
                    $string = str_replace('</pre>', '```', $string);
                }
            } else {
                if ($line !== $maxLine - 1 && isset($contentArray[$line + 1]) && trim($contentArray[$line + 1]) !== '') {
                    $string = str_replace('</pre>', "\n```".PHP_EOL, $string);
                } else {
                    $string = str_replace('</pre>', '\n```', $string);
                }
            }

            // 替换链接
            $string = preg_replace('/^\[(http.*?) (.*?)]$/', "[$2]($1)\n", $string);

            // ``` 后需要另起一行
            $string = preg_replace('/^(.*?)```$/', "$1\n```\n", $string);
            $string = preg_replace('/^```shell(.*?)$/', "```shell\n$1", $string);

            // 替换 syntaxhighlight
            $string = preg_replace('/<syntaxhighlight lang="(.*?)">/', "```$1", $string);
            $string = preg_replace('/<\/syntaxhighlight>/', "```", $string);

            // 替换 =
            if (preg_match('/^(=+)(.*?)(=+)$/', $string, $matches)) {
                if ($matches[1] === $matches[3]) {
                    $string = str_repeat('#', strlen($matches[1])).' '.$matches[2];
                    $string .= PHP_EOL;
                }
            } else {
                $string .= PHP_EOL;
            }

            $markdown .= $string;
        }

        return $markdown;
    }
}
