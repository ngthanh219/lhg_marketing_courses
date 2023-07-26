<?php

namespace Database\Seeders;

use App\Libraries\Constant;
use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                'id' => 1,
                'name' => 'TẠO KÊNH TIKTOK & EDIT VIDEO CHUYÊN NGHIỆP',
                'slug' => Str::slug('TẠO KÊNH TIKTOK & EDIT VIDEO CHUYÊN NGHIỆP'),
                'slogan' => null,
                'introduction' => null,
                'description' => null,
                'image' => null,
                'price' => 4350000,
                'discount' => 0,
                'discount_price' => (double) (4350000 - ((4350000 * (0 / 100)) * 100 / 100)),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 2,
                'name' => 'TẠO KÊNH YOUTUBE CHUẨN & THIẾT KẾ CANVA',
                'slug' => Str::slug('TẠO KÊNH YOUTUBE CHUẨN & THIẾT KẾ CANVA'),
                'slogan' => null,
                'introduction' => null,
                'description' => null,
                'image' => null,
                'price' => 4350000,
                'discount' => 0,
                'discount_price' => (double) (4350000 - ((4350000 * (0 / 100)) * 100 / 100)),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 3,
                'name' => 'BÁN HÀNG TRÊN TIKTOK',
                'slug' => Str::slug('BÁN HÀNG TRÊN TIKTOK'),
                'slogan' => null,
                'introduction' => null,
                'description' => null,
                'image' => null,
                'price' => 4350000,
                'discount' => 0,
                'discount_price' => (double) (4350000 - ((4350000 * (0 / 100)) * 100 / 100)),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 4,
                'name' => 'Zalo Marketing AuToMaTion',
                'slug' => Str::slug('Zalo Marketing AuToMaTion'),
                'slogan' => null,
                'introduction' => null,
                'description' => null,
                'image' => null,
                'price' => 4350000,
                'discount' => 0,
                'discount_price' => (double) (4350000 - ((4350000 * (0 / 100)) * 100 / 100)),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
