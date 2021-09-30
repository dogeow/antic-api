<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TestExport implements FromArray, WithHeadings, ShouldAutoSize
{
    use Exportable;

    public function array(): array
    {
        return [
            ['测试', '测试值'],
            ['测试2', '测试值2'],
        ];
    }

    public function headings(): array
    {
        return [
            '字段',
            '值',
        ];
    }
}
