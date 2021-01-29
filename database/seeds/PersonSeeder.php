<?php

use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/users"));

        foreach ($json as $person) {
            $date = randomDate();

            DB::table('persons')->insert([
                'name' => $person->name,
                'username' => $person->username, 
                'email' => $person->email, 
                'street' => $person->address->street,
                'suite' => $person->address->suite,
                'city' => $person->address->city,
                'zipcode' => $person->address->zipcode,
                'geo_lat' => $person->address->geo->lat,
                'geo_lng' => $person->address->geo->lng,
                'phone' => $person->phone,
                'website' => $person->website,
                'company_name' => $person->company->name,
                'company_catch_phrase' => $person->company->catchPhrase,
                'company_bs' => $person->company->bs,
                'created_at' => $date,
                'updated_at' => $date
            ]);
        }
    }
}
