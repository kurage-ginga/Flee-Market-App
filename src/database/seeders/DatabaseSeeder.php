<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('ja_JP');

        $this->call([
            CategorySeeder::class,
            ConditionSeeder::class,
        ]);

        $categoryIds = \App\Models\Category::pluck('id')->toArray();

        $conditionMap = \App\Models\Condition::pluck('id', 'name')->toArray();

        $user = User::factory()->create(['id' => 1]);

        $items = [
            ['腕時計', 15000, 'スタイリッシュなデザインのメンズ腕時計', 'uploads/Armani+Mens+Clock.jpg', '良好'],
            ['HDD', 5000, '高速で信頼性の高いハードディスク', 'uploads/HDD+Hard+Disk.jpg', '目立った傷や汚れなし'],
            ['玉ねぎ3束', 300, '新鮮な玉ねぎ3束のセット', 'uploads/iLoveIMG+d.jpg', 'やや傷や汚れあり'],
            ['革靴', 4000, 'クラシックなデザインの革靴', 'uploads/Leather+Shoes+Product+Photo.jpg', '状態が悪い'],
            ['ノートPC', 45000, '高性能なノートパソコン', 'uploads/Living+Room+Laptop.jpg', '良好'],
            ['マイク', 8000, '高音質のレコーディング用マイク', 'uploads/Music+Mic+4632231.jpg', '目立った傷や汚れなし'],
            ['ショルダーバッグ', 3500, 'おしゃれなショルダーバッグ', 'uploads/Purse+fashion+pocket.jpg', 'やや傷や汚れあり'],
            ['タンブラー', 500, '使いやすいタンブラー', 'uploads/Tumbler+souvenir.jpg', '状態が悪い'],
            ['コーヒーミル', 4000, '手動のコーヒーミル', 'uploads/Waitress+with+Coffee+Grinder.jpg', '良好'],
            ['メイクセット', 2500, '便利なメイクアップセット', 'uploads/外出メイクアップセット.jpg', '目立った傷や汚れなし'],
        ];

        $index = 0;

        foreach ($items as $item) {
            $status = $index === 0 ? 1 : 0;

            $savedItem = Item::create([
                'user_id' => $user->id,
                'category_id' => $faker->randomElement($categoryIds),
                'condition_id' => $conditionMap[$item[4]],
                'name' => $item[0],
                'price' => $item[1],
                'description' => $item[2],
                'status' => $status,
                'image_path' => $item[3],
            ]);
            $index++;
        }
    }
}
