<?php

namespace Database\Seeders;

use App\Libraries\Constant;
use App\Models\Video;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Video::insert([
            [
                'id' => 1,
                'course_section_id' => 1,
                'name' => 'Bài 1: Tạo Kênh TikTok Bằng Email',
                'description' => 'Video 1',
                'source' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'course_section_id' => 1,
                'name' => 'Bài 2: Tạo avata Thu Hút Kết Nối Youtube Vào Kênh',
                'description' => 'Video 2',
                'source' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'course_section_id' => 1,
                'name' => 'Bài 3: Chỉnh Sửa Thông Tin & Chính Sách TikTok',
                'description' => 'Video 3',
                'source' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'course_section_id' => 1,
                'name' => 'Bài 4: Các Chính Sách & Chuẩn Bị Khi Quay Video',
                'description' => 'Video 4',
                'source' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
