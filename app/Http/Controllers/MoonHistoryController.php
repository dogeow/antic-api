<?php

namespace App\Http\Controllers;

use App\Models\Moon;
use App\Models\MoonHistory;
use Illuminate\Http\Request;

class MoonHistoryController extends Controller
{
    private $defRank = 'none';

    public function lottery()
    {
        $dice = $this->rollDice();
        $format = $this->formatDice($dice);
        $rank = $this->getRank($format);
        $rankName = $this->getName($rank);

        return [
            'dice' => $dice,
            'rank' => $rank,
            'rankName' => $rankName,
        ];
    }

    /**
     * 获取筛子排名结果.
     * @param $dice
     * @return array
     */
    public function getRes($dice)
    {
        $format = $this->formatDice($dice);
        $rank = $this->getRank($format);
        $rankName = $this->getName($rank);

        return [
            'dice' => $dice,
            'format' => $format,
            'rank' => $rank,
            'rankName' => $rankName,
        ];
    }

    /**
     * 掷骰子.
     * @return array
     */
    public function rollDice()
    {
        $res = [];
        for ($i = 0; $i < 6; $i++) {
            $res[] = mt_rand(1, 6);
        }

        return $res;
    }

    /**
     * 格式化掷骰子结果.
     * @param  array  $list
     * @return array
     */
    public function formatDice($list = [])
    {
        $data = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0,
            6 => 0,
        ];
        foreach ($list as $val) {
            if (isset($data[$val])) {
                $data[$val] += 1;
            }
        }
        foreach ($data as $key => $val) {
            if ($val === 0) {
                unset($data[$key]);
            }
        }

        return $data;
    }

    /**
     * 判断筛子结果的大小.
     * @param $list
     * @return int|string
     */
    public function getRank($list)
    {
        $ruleList = $this->getRule();
        $res = $this->defRank;
        if (! empty($ruleList)) {
            foreach ($ruleList as $rank => $rankRules) {
                foreach ($rankRules as $rule) {
                    foreach ($rule as $dian => $num) {
                        if (isset($list[$dian])) {
                            if ($list[$dian] == $num) {
                                $res = $rank;
                            } else {
                                //规则中只要有一条不满足就跳出当前规则验证
                                $res = $this->defRank;
                                break;
                            }
                        } else {
                            //规则中只要有一条不满足就跳出当前规则验证
                            $res = $this->defRank;
                            break;
                        }
                    }
                    //有一条规则匹配，跳出循环，
                    if ($res != $this->defRank) {
                        break;
                    }
                }
                //有一条规则匹配，跳出循环，
                if ($res != $this->defRank) {
                    break;
                }
            }
        }

        return $res;
    }

    /**
     * 根据排序获取掷骰子结果名称.
     * @param  string  $rank
     * @return mixed
     */
    public function getName($rank)
    {
        $list = [
            'cjh' => '状元插金花',
            'lbh' => '六杯红',
            'bdj' => '遍地锦',
            'ww' => '五王',
            'wzdyx' => '五子带一秀',
            'wzdk' => '五子登科',
            'zy' => '状元',
            'by' => '榜眼',
            'sh' => '三红',
            'sj' => '四进',
            'eq' => '二举',
            'yx' => '一秀',
            'none' => '没有',
        ];
        if (! empty($rank)) {
            if (isset($list[$rank])) {
                return $list[$rank];
            }
        }

        return $list;
    }

    /**
     * 返回规则.
     * @return array
     */
    private function getRule()
    {
        return [
            'cjh' => [
                [2 => 2, 4 => 4],
            ],
            'lbh' => [
                [4 => 6],
            ],
            'bdj' => [
                [1 => 6],
                [2 => 6],
                [3 => 6],
                [5 => 6],
                [6 => 6],
            ],
            'ww' => [
                [4 => 5],
            ],
            'wzdyx' => [
                [1 => 5, 4 => 1],
                [2 => 5, 4 => 1],
                [3 => 5, 4 => 1],
                [5 => 5, 4 => 1],
                [6 => 5, 4 => 1],
            ],
            'wzdk' => [
                [1 => 5],
                [2 => 5],
                [3 => 5],
                [5 => 5],
                [6 => 5],
            ],
            'zy' => [
                [4 => 4],
            ],
            'by' => [
                [1 => 1, 2 => 1, 3 => 1, 4 => 1, 5 => 1, 6 => 1],
            ],
            'sh' => [
                [4 => 3],
            ],
            'sj' => [
                [1 => 4],
                [2 => 4],
                [3 => 4],
                [5 => 4],
                [6 => 4],
            ],
            'eq' => [
                [4 => 2],
            ],
            'yx' => [
                [4 => 1],
            ],
        ];
    }

    public function start(Request $request)
    {
        $moon = Moon::where('name', $request->moon)->first();
        if (count($moon->moonHistory) >= 6) {
            return '已满6次！';
        }
        $lottery = $this->lottery();
        $moon = Moon::where('name', $request->moon)->first();
        MoonHistory::create(
            [
                'moon_id' => $moon->id,
                'num1' => $lottery['dice'][0],
                'num2' => $lottery['dice'][1],
                'num3' => $lottery['dice'][2],
                'num4' => $lottery['dice'][3],
                'num5' => $lottery['dice'][4],
                'num6' => $lottery['dice'][5],
                'name' => $lottery['rankName'],
            ]
        );

        return array_merge($lottery, ['history' => $moon->moonHistory->toArray()]);
    }
}
