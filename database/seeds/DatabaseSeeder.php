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
        $ownerId = DB::table('users')->insertGetId([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => 'Owner',
            'email' => 'ser.nikiforov@gmail.com',
            'password' => Hash::make('password'),
            'role' => 4,
        ]);
        $tariffId = DB::table('tariffs')->insertGetId([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'slug' => 'free',
            'name' => "Бесплатный",
            'price' => 0,
            'currency' => 'RUB',
            'period' => 'endless',
            'prolongable' => false,
            'features' => '[]',
        ]);
        DB::table('subscriptions')->insert([
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'slug' => 'free',
            'name' => "Бесплатный",
            'price' => 0,
            'currency' => 'RUB',
            'period' => 'endless',
            'prolongable' => false,
            'features' => '[]',
            'tariff_id' => $tariffId,
            'user_id' => $ownerId,
            'status' => 'Active',
        ]);
    }
}
