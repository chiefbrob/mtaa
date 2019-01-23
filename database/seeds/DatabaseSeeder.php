<?php

use Illuminate\Database\Seeder;
use Dabotap\User;
use Dabotap\Town;
use Dabotap\Estate;
use Dabotap\House;
use Dabotap\Group;
use Dabotap\Term;
use Dabotap\Tip;
use Dabotap\Cat;

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
        Term::create([
            'contents' => 'Dabotap Security Framework is an application that when used appropriately would boost your own security. You are required to respect Kenyans resolution to fight crime with this application, and other modes. Misuse of this application would be prosecuted'
        ]);

        Cat::create([
            'title' => 'text',
            'description' => 'This is a tip conveyed via writings'
        ]);

        Cat::create([
            'title' => 'audio',
            'description' => 'This is a tip conveyed via audio recording'
        ]);

        Cat::create([
            'title' => 'media',
            'description' => 'This is a tip conveyed via image or video'
        ]);


        Town::create([
        	'title' => 'Eldoret'
        ]);

        Estate::create([
        	'title' => 'Racecourse Estate Eldoret',
        	'user_id' => 1,
        	'town_id' => 1
        ]);

        House::create([
        	'number' => '54 Block A',
        	'estate_id' => 1,
        	'group_id' => 1,
        ]);

        Group::create([
        	'number' => '54 Block A',
        	'estate_id' => 1,
        	'user_id' => 1
        ]);

        User::create([
        	'name' => 'Timothy M',
        	'username' => 'timo',
        	'email' => 'timo@lughayetu.net',
            'gender' => 'bot',
        	'phone' => '+254000000000',
        	'house_id' => 1,
        	'role' => 'admin',
        	'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'
        ]);
    }
}
