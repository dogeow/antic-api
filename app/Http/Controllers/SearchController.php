<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Nesk\Puphpeteer\Puppeteer;
use Symfony\Component\DomCrawler\Crawler;

class SearchController extends Controller
{
    public const empty = [
        'data' => [],
        'count' => 0,
    ];

    public function search(Request $request)
    {
        $query = $request->get('q');
        if ($query === null) {
            return ['error'];
        }

        $puppeteer = new Puppeteer();
        $browser = $puppeteer->launch([
            'args' => ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=300,400'],
        ]);

        $page = $browser->newPage();
        $page->goto("https://www.google.com/search?q={$query}&num=10&start=0&hl=zh-CN");
        $html = $page->content();

        $browser->close();

        $crawler = new Crawler();
        $crawler->addHtmlContent($html);

        $count = null;
        try {
            $searchResultCount = $crawler->filterXPath("//div[@id='result-stats']")->text();
            if (preg_match('/找到约 (.*?) 条结果/u', $searchResultCount, $match)) {
                $count = str_replace(',', '', $match[1]);
            }

            $result = $crawler->filterXPath("//div[@id='search']//div[@class='g']")->each(function (Crawler $node, $i): void {
                if ($node->filterXPath('//h3')->count() === 0 || $node->filterXPath('//cite')->count() === 0
                    || $node->filterXPath('//span[@class="st"]')->count() === 0) {
                    return;
                }

                return [
                    'title' => $node->filterXPath('//h3')->text(),
                    'url' => $node->filterXPath('//cite')->text(),
                    'intro' => $node->filterXPath('//span[@class="st"]')->html(),
                ];
            });
        } catch (\InvalidArgumentException $e) {
            return self::empty;
        }

        return [
            'data' => array_filter($result),
            'count' => $count,
        ];
    }
}
