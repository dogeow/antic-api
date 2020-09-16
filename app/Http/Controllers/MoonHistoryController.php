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
        $rankNameAndMoney = $this->getName($rank);

        return [
            'dice' => $dice,
            'rank' => $rank,
            'rankName' => $rankNameAndMoney['name'],
            'money' => $rankNameAndMoney['money'],
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
            'cjh' => [
                'name' => '状元插金花',
                'money' => 2.33,
            ],
            'lbh' => [
                'name' => '六杯红',
                'money' => 2.33,
            ],
            'bdj' => [
                'name' => '遍地锦',
                'money' => 2.33,
            ],
            'ww' => [
                'name' => '五王',
                'money' => 1.68,
            ],
            'wzdyx' => [
                'name' => '五子带一秀',
                'money' => 1.88,
            ],
            'wzdk' => [
                'name' => '五子登科',
                'money' => 1.68,
            ],
            'zy' => [
                'name' => '状元',
                'money' => 1.11,
            ],
            'by' => [
                'name' => '榜眼',
                'money' => 1.23,
            ],
            'sh' => [
                'name' => '三红',
                'money' => 0.33,
            ],
            'sj' => [
                'name' => '四进',
                'money' => 0.4,
            ],
            'eq' => [
                'name' => '二举',
                'money' => 0.2,
            ],
            'yx' => [
                'name' => '一秀',
                'money' => 0.1,
            ],
            'none' => [
                'name' => '没有',
                'money' => 0.01,
            ],
        ];

        return $list[$rank];
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
        $user = Moon::where('name', $request->user)->first();
        if (count($user->moonHistory) >= 6) {
            return '已满6次！';
        }
        $lottery = $this->lottery();
        MoonHistory::create(
            [
                'moon_id' => $user->id,
                'num1' => $lottery['dice'][0],
                'num2' => $lottery['dice'][1],
                'num3' => $lottery['dice'][2],
                'num4' => $lottery['dice'][3],
                'num5' => $lottery['dice'][4],
                'num6' => $lottery['dice'][5],
                'name' => $lottery['rankName'],
                'money' => $lottery['money'],
            ]
        );

        $user = $user->fresh('moonHistory');

        return array_merge(
            $lottery,
            [
                'history' => $user->moonHistory->toArray(),
                'statistics' => (new Moon)->statistics(),
            ]
        );
    }
}
