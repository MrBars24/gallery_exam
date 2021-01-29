<?php

use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/albums"));

        foreach ($json as $album) {
            $date = randomDate();

            DB::table('albums')->insert([
                'person_id' => $album->userId,
                'title' => $album->title,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
