<?php

namespace App\Http\Controllers;

use App\Exports\TestExport;
use App\Models\Api;
use App\Models\User;
use App\Services\UpyunService;
use Exception;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\JiebaAnalyse;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Ip2location\IP2LocationLaravel\Facade\IP2LocationLaravel;
use Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApiController extends Controller
{
    private readonly GuzzleClient $guzzleClient;

    public function __construct()
    {
        $this->guzzleClient = new GuzzleClient([
            'timeout' => 10,
        ]);
    }

    public function index(): Collection
    {
        return Api::all();
    }

    /**
     * @throws Exception
     */
    public function images(Request $request)
    {
        $cacheKey = 'upyun_wallpaper';
        $wallpaperCollect = Cache::remember($cacheKey, 86400, function () {
            return (new UpyunService())->getFiles('wallpaper', true);
        });

        if ($request->query('action') === 'random') {
            $randomWallpaper = $wallpaperCollect->random();
            $url = sprintf('%s/wallpaper/%s%s', config('services.upyun_endpoint'), $randomWallpaper, '!/fw/1920');

            return redirect($url);
        }

        return $wallpaperCollect;
    }

    /**
     * xlsx 文件，默认 action 为 download，直接下载文件
     */
    public function xlsx(Request $request): Response|BinaryFileResponse
    {
        if ($request->query('action') === 'export') {
            return (new TestExport())->download('test.xlsx');
        }

        return response()->file(storage_path('app/public/test.xlsx'));
    }

    /**
     * 记录回调信息
     */
    public function callback(Request $request): void
    {
        Log::info(var_export($request->all(), true));
    }

    public function number(Request $request, int $start, int $end): array
    {
        $count = strlen((string) $end);
        $numberRange = range($start, $end);
        foreach ($numberRange as &$number) {
            $number = (string) $number;
            if ($count > strlen($number)) {
                $zeroCount = $count - strlen($number);
                $number = str_repeat('0', $zeroCount).$number;
            }
        }
        unset($number);

        if (in_array('shuffle', (array) $request->query('actions'), true)) {
            shuffle($numberRange);
        }

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
            $status = (bool) preg_match("/onclick='tc\(\"${item}\".*?\)'/", $html);
            $data[] = [
                'id' => $key,
                'status' => $status,
            ];
        }

        return $data;
    }

    public function idnToAscii($domain = ''): string
    {
        return idn_to_ascii($domain);
    }

    public function idnToUtf8($domain = ''): string
    {
        return idn_to_utf8($domain);
    }

    public function unicode_to_utf8($string): string
    {
        $code = (int) hexdec((string) $string);
        // 这里注意转换出来的 code 一定得是整形，这样才会正确的按位操作
        $ord_1 = decbin(0xE0 | ($code >> 12));
        $ord_2 = decbin(0x80 | (($code >> 6) & 0x3F));
        $ord_3 = decbin(0x80 | ($code & 0x3F));

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
        return base64_encode((string) $string);
    }

    public function base64_decode($string = ''): bool|string
    {
        return base64_decode((string) $string);
    }

    public function urlEncode($string = ''): string
    {
        return urlencode((string) $string);
    }

    public function urlDecode($string = ''): string
    {
        return urldecode((string) $string);
    }

    public function image($action = null): BinaryFileResponse|string
    {
        $uri = '/sticker.webp';

        return match ($action) {
            'download' => response()->download(public_path($uri), 'sticker.webp'),
            default => url($uri),
        };
    }

    public function md5($string = ''): string
    {
        return md5((string) $string);
    }

    public function userAgent()
    {
        return request()->header('User-Agent');
    }

    public function sha($string): string
    {
        return sha1((string) $string);
    }

    public function date(int $timestamp = null): string
    {
        return isset($timestamp) ? date('Y-m-d', $timestamp) : date('Y-m-d');
    }

    public function datetimeToTimestamp(int $timestamp = null): string
    {
        return isset($timestamp) ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d H:i:s');
    }

    public function timestamp($date = null): bool|int
    {
        return $date ? strtotime((string) $date) : time();
    }

    public function bankcard($cardNo): bool|string
    {
        $url = 'https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo='.$cardNo.'&cardBinCheck=true';
        try {
            $resp = file_get_contents($url);
        } catch (Exception $e) {
            return '接口异常';
        }
        $data = json_decode($resp, true, 512, JSON_THROW_ON_ERROR);
        if (isset($data['validated']) && $data['validated'] === false) {
            return '信用卡卡号格式错误';
        }

        return $resp;
    }

    public function secret($string = ''): string
    {
        return str_repeat('*', strlen((string) $string));
    }

    public function hash($string = ''): string
    {
        return sha1((string) $string);
    }

    public function htmlSC($string): string
    {
        if (str_starts_with((string) $string, '&')) {
            return htmlspecialchars_decode((string) $string);
        }

        return htmlspecialchars((string) $string);
    }

    public function ip($ip = null): string|\Illuminate\Http\Client\Response|null
    {
        return $ip ? self::getIpGeolocation($ip) : request()->ip();
    }

    /**
     * @param $ip
     * @return array
     */
    public static function getIpGeolocation($ip): array
    {
        $records = IP2LocationLaravel::get($ip, 'bin');

        return [
            'ipAddress' => $records['ipAddress'],
            'ipNumber' => $records['ipNumber'],
            'countryName' => $records['countryName'],
            'countryCode' => $records['countryCode'],
            'regionName' => $records['regionName'],
            'cityName' => $records['cityName'],
            'latitude' => $records['latitude'],
            'longitude' => $records['longitude'],
        ];
    }

    public function case($content): string
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

    public function mediawikiToMarkdown(Request $request): string
    {
        $mediawiki = $request->input('mediawiki');

        $contentArray = explode(PHP_EOL, (string) $mediawiki);
        $maxLine = count($contentArray);

        $markdown = '';

        foreach ($contentArray as $line => $string) {
            if (strlen($string) > 2 && $string[0] === '*' && ! in_array($string[1], ['*', ' '], true)) {
                $string = $string[0].' '.substr($string, 1);
            }

            // 替换 code
            $string = str_replace(['<code>', '</code>'], '`', $string);

            // 替换 pre
            if ($string === '<pre>') {
                if ($line !== 0 && trim($contentArray[$line - 1]) !== '') {
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

            if ($string === '</pre>') {
                if ($line !== $maxLine - 1 && trim($contentArray[$line + 1]) !== '') {
                    $string = str_replace('</pre>', '```'.PHP_EOL, $string);
                } else {
                    $string = str_replace('</pre>', '```', $string);
                }
            } elseif ($line !== $maxLine - 1 && isset($contentArray[$line + 1]) && trim($contentArray[$line + 1]) !== '') {
                $string = str_replace('</pre>', "\n```".PHP_EOL, $string);
            } else {
                $string = str_replace('</pre>', '\n```', $string);
            }

            // 替换链接
            $string = preg_replace('/^\[(http.*?) (.*?)]$/', "[$2]($1)\n", $string);

            // ``` 后需要另起一行
            $string = preg_replace('/^(.*?)```$/', "$1\n```\n", $string);
            $string = preg_replace('/^```shell(.*?)$/', "```shell\n$1", $string);

            // 替换 syntaxhighlight
            $string = preg_replace('/<syntaxhighlight lang="(.*?)">/', '```$1', $string);
            $string = preg_replace('/<\/syntaxhighlight>/', '```', $string);

            // 替换 =
            if (preg_match('/^(=+)(.*?)(=+)$/', $string, $matches)) {
                if ($matches[1] === $matches[3]) {
                    $string = str_repeat('#', strlen((string) $matches[1])).' '.$matches[2];
                    $string .= PHP_EOL;
                }
            } else {
                $string .= PHP_EOL;
            }

            $markdown .= $string;
        }

        return $markdown;
    }

    /**
     * @return User
     */
    public function ab()
    {
        return User::findOrFail(1);
    }

    /**
     * 关键词提取
     */
    public function keywords(string $content): array
    {
        ini_set('memory_limit', '-1');

        $jieba = new Jieba();
        $jieba::init();

        $jiebaAnalyse = new JiebaAnalyse();
        $jiebaAnalyse::init();

        Finalseg::init();

        return $jiebaAnalyse::extractTags($content, 10, ['n']);
    }

    public function ai(Request $request)
    {
        $request->validate([
            'content' => ['required', 'string', 'min:2', 'max:255'],
        ]);

        $client = new GuzzleClient([
            'timeout' => 60,
        ]);

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.config('services.openai.api_key'),
        ];

        $body = [
            'model' => 'gpt-4-0613',
            'messages' => [
                ['role' => 'user', 'content' => $request->input('content')],
            ],
        ];

        // https://api.openai.com/v1/chat/completions
        $response = $client->post('https://openkey.cloud/v1/chat/completions', [
            'headers' => $headers,
            'json' => $body,
        ]);

        $result = json_decode((string) $response->getBody(), true);

        Log::info('OpenAI', $result);

        return $result['choices'][0]['message']['content'];
    }
}
