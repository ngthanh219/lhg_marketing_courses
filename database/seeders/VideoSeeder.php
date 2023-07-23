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
                'description' => 'Video 1',
                'source_url' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'course_section_id' => 1,
                'description' => 'Video 2',
                'source_url' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'course_section_id' => 1,
                'description' => 'Video 3',
                'source_url' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 4,
                'course_section_id' => 1,
                'description' => 'Video 4',
                'source_url' => 'videos/ex.mp4',
                'duration' => 30,
                'is_show' => Constant::IS_SHOW,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
