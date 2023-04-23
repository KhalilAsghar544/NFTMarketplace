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
        $this->call(UsersTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(AdminSettingTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CoinTableSeeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(SlidersTableSeeder::class);
        $this->call(FaqHeadsSeeder::class);
        $this->call(FaqTableSeeder::class);
        $this->call(TopArtistsTableSeeder::class);
        $this->call(FollowsTableSeeder::class);
        $this->call(SevicesTableSeeder::class);
        $this->call(WithdrawlsTableSeeder::class);
        $this->call(DepositsTableSeeder::class);
        $this->call(NewsTableSeeder::class);
        $this->call(BidSeeder::class);
        $this->call(ServiceCharesTableSeeder::class);
        $this->call(ContentsTableSeeder::class);
    }
}
