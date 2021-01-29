<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->seed();
    }

    protected function seed()
	{
        Model::unguard();

		// reset
		$this->database_purge();

		// data
		$this->call(PersonSeeder::class);
		$this->call(AlbumSeeder::class);
		$this->call(PhotoSeeder::class);

		Model::reguard();
    }

    private function database_purge() {
        $tables = [
			'persons',
            'users',
            'photos',
            'albums',
		];

        foreach($tables as $table) {
			Schema::disableForeignKeyConstraints();
			DB::table($table)->delete();
			DB::statement('ALTER TABLE `' . $table . '` AUTO_INCREMENT = 1');
			Schema::enableForeignKeyConstraints();

		}
    }
}
