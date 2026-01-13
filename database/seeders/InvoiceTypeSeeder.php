<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InvoiceType;

class InvoiceTypeSeeder extends Seeder
{
    public function run()
    {
        // 初期データの配列
        $types = [
            '請求書',
            '納品書',
            '見積書',
        ];

        // ループで投入
        foreach ($types as $name) {
            InvoiceType::firstOrCreate(
                ['DocumentType' => $name] // DocumentType が同じなら重複登録しない
            );
        }
    }
}
