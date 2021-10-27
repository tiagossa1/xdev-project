<?php

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
        $this->call(ForbiddenWordSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(SchoolClassSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(UserTypeSeeder::class);
        $this->call(FeedbackTypeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PostTypeSeeder::class);
        $this->call(FeedbackSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(PostSeeder::class);
        $this->call(ReportConclusionSeeder::class);
        $this->call(ReportSeeder::class);
        $this->call(PostPhotoSeeder::class);
        $this->call(CommentSeeder::class);
    }
}
