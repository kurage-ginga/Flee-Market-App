<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\ItemImage;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create(['id' => 1]);

        $items = Item::factory(10)->make();

        foreach ($items as $item) {

            $savedItem = Item::create([
                'user_id' => $item->user_id,
                'name' => $item->name,
                'price' => $item->price,
                'description' => $item->description,
                'condition' => $item->condition,
            ]);

            ItemImage::create([
                'item_id' => $savedItem->id,
                'image_url' => $item->image_temp_url,
            ]);
        }


        $this->call([
            CategorySeeder::class,
        ]);
    }
}
