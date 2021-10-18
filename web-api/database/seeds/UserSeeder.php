<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(\App\User::class,10)->create();

        App\User::create([
            'name' => 'Andre Teixeira',
            'email' => 'andre.teixeira.t0119600@edu.atec.pt',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'birth_date' => '1992-11-18',
            'github_url' => "www.github.com",
            'linkedin_url' => "www.linked.com",
            'facebook_url' => "www.facebook.com",
            'instagram_url' => "www.instagram.com",
            'user_type_id' => 4,
            'district_id' => 13,
            'school_class_id' => 51,
            'suspended' => 0
        ]);

        App\User::create([
            'name' => 'Tiago Sá',
            'email' => 'tiago.sa.t0119181@edu.atec.pt',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'birth_date' => '2000-10-30',
            'github_url' => "www.github.com",
            'linkedin_url' => "www.linked.com",
            'facebook_url' => "www.facebook.com",
            'instagram_url' => "www.instagram.com",
            'user_type_id' => 4,
            'district_id' => 3,
            'school_class_id' => 51,
            'suspended' => 0
        ]);

        App\User::create([
            'name' => 'Jorge Faria',
            'email' => 'jorge.faria.t0119174@edu.atec.pt',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'birth_date' => '1991-08-08',
            'github_url' => "www.github.com",
            'linkedin_url' => "www.linked.com",
            'facebook_url' => "www.facebook.com",
            'instagram_url' => "www.instagram.com",
            'user_type_id' => 4,
            'district_id' => 13,
            'school_class_id' => 51,
            'suspended' => 0
        ]);

        App\User::create([
            'name' => 'Edgar Fernandes',
            'email' => 'edgar.fernandes.t0119166@edu.atec.pt',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'birth_date' => '1999-05-31',
            'github_url' => "www.github.com",
            'linkedin_url' => "www.linked.com",
            'facebook_url' => "www.facebook.com",
            'instagram_url' => "www.instagram.com",
            'user_type_id' => 4,
            'district_id' => 13,
            'school_class_id' => 51,
            'suspended' => 0
        ]);

    }
}
