<?php

namespace Database\Seeders;

use App\Libraries\Constant;
use App\Models\CourseSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'name' => 'Bài 1: Tạo Kênh TikTok Bằng Email',
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 2,
                'course_id' => 1,
                'name' => 'Bài 2: Tạo avata Thu Hút Kết Nối Youtube Vào Kênh',
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 3,
                'course_id' => 1,
                'name' => 'Bài 3: Chỉnh Sửa Thông Tin & Chính Sách TikTok',
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ], [
                'id' => 4,
                'course_id' => 1,
                'name' => 'Bài 4: Các Chính Sách & Chuẩn Bị Khi Quay Video',
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
