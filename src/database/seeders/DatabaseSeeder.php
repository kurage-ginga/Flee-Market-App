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
            ['腕時計', 15000, 'スタイリッシュなデザインのメンズ腕時計', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg', '良好'],
            ['HDD', 5000, '高速で信頼性の高いハードディスク', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg', '目立った傷や汚れなし'],
            ['玉ねぎ3束', 300, '新鮮な玉ねぎ3束のセット', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg', 'やや傷や汚れあり'],
            ['革靴', 4000, 'クラシックなデザインの革靴', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg', '状態が悪い'],
            ['ノートPC', 45000, '高性能なノートパソコン', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg', '良好'],
            ['マイク', 8000, '高音質のレコーディング用マイク', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg', '目立った傷や汚れなし'],
            ['ショルダーバッグ', 3500, 'おしゃれなショルダーバッグ', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg', 'やや傷や汚れあり'],
            ['タンブラー', 500, '使いやすいタンブラー', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg', '状態が悪い'],
            ['コーヒーミル', 4000, '手動のコーヒーミル', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg', '良好'],
            ['メイクセット', 2500, '便利なメイクアップセット', 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg', '目立った傷や汚れなし'],
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
            ]);

            ItemImage::create([
                'item_id' => $savedItem->id,
                'image_path' => $item[3],
            ]);

            $index++;
        }
    }
}
