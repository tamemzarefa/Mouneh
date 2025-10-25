<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'oils', 'name_ar' => 'الزيوت', 'name_en' => 'Oils'],
            ['slug' => 'honey', 'name_ar' => 'العسل', 'name_en' => 'Honey'],
            ['slug' => 'dairy', 'name_ar' => 'الألبان ومشتقاتها', 'name_en' => 'Dairy'],
            ['slug' => 'spices', 'name_ar' => 'التوابل والبهارات', 'name_en' => 'Spices'],
            ['slug' => 'dried-foods', 'name_ar' => 'المجففات', 'name_en' => 'Dried Foods'],
            ['slug' => 'jams-preserves', 'name_ar' => 'المربيات', 'name_en' => 'Jams & Preserves'],
            ['slug' => 'grains-legumes', 'name_ar' => 'الحبوب والبقوليات', 'name_en' => 'Grains & Legumes'],
            ['slug' => 'herbal-wellness', 'name_ar' => 'الأعشاب والمنتجات الصحية', 'name_en' => 'Herbal & Wellness'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->updateOrInsert(
                ['slug' => $cat['slug']],
                [
                    'name_ar' => $cat['name_ar'],
                    'name_en' => $cat['name_en'] ?? null,
                    'parent_id' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
