<?php

use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/photos"));

        foreach ($json as $photo) {
            $date = randomDate();

            DB::table('photos')->insert([
                'album_id' => $photo->albumId,
                'title' => $photo->title,
                'url' => $photo->url,
                'thumbnail_url' => $photo->thumbnailUrl,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
