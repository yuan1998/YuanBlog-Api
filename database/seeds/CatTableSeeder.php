<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $cat = [
          [
              'title'=>'test',
              'description' => 'des',
              'title_en' => 'english title',
              'created_at' => $now,
              'updated_at' => $now,
          ],
          [
              'title'=>'test1',
              'description' => 'des',
              'title_en' => 'english title',
              'created_at' => $now,
              'updated_at' => $now,
          ],
          [
              'title'=>'test2',
              'description' => 'des',
              'title_en' => 'english title',
              'created_at' => $now,
              'updated_at' => $now,
          ],
        ];

        foreach ($cat as $item)
        {
            Category::create($item);
        }
    }
}
