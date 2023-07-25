<?php

namespace Database\Seeders;

use App\Libraries\Constant;
use App\Models\CourseSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseSection::insert([
            [
                'id' => 1,
                'course_id' => 1,
                'name' => 'PHẦN 1 : Tạo Lading page Cơ Bản',
                'slug' => Str::slug('PHẦN 1 : Tạo Lading page Cơ Bản'),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 2,
                'course_id' => 1,
                'name' => 'PHẦN 2: Thiết Kế Chuyên Sâu Cho Ladipage',
                'slug' => Str::slug('PHẦN 2: Thiết Kế Chuyên Sâu Cho Ladipage'),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 3,
                'course_id' => 1,
                'name' => 'PHẦN 3: Tạo hệ thống bán hàng automation',
                'slug' => Str::slug('PHẦN 3: Tạo hệ thống bán hàng automation'),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 4,
                'course_id' => 1,
                'name' => 'PHẦN 4: Chuẩn bị để tự tin quay video chuyên nghiệp',
                'slug' => Str::slug('PHẦN 4: Chuẩn bị để tự tin quay video chuyên nghiệp'),
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
