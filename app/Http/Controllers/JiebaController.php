<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\JiebaAnalyse;

class JiebaController extends Controller
{
    public mixed $jiebaAnalyse;

    public function __construct()
    {
        ini_set('memory_limit', '-1');

        $jieba = new Jieba();
        $jieba::init();

        $jiebaAnalyse = new JiebaAnalyse();
        $jiebaAnalyse::init();
        $this->jiebaAnalyse = $jiebaAnalyse;

        Finalseg::init();
    }

    /**
     * 关键词提取
     *
     * @return array
     */
    public function keywords(string $content): array
    {
        return $this->jiebaAnalyse::extractTags($content, 10, ['n']);
    }
}
