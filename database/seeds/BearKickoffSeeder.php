<?php

use Illuminate\Database\Seeder;
use Rudivdme\BearContent\Models\User;

class BearKickoffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'id'         => 1,
            'first_name' => 'Super',
            'last_name'  => 'Bear',
            'email'      => 'admin@bear.media',
            'password'   => bcrypt('password'),
            'role'       => 'super',
            'status'     => 'active',
        ]);

        \DB::table('pages')->insert([
            'id'              => 1,
            'title'           => 'Home',
            'slug'            => '/',
            'layout'          => 'homepage',
            'entity'          => 'home',
            'scope'           => 'public',
            'linked'          => true,
            'static_layout'   => true,
            'status'          => 'published',
        ]);

        \DB::table('menus')->insert([
            'id'      => 1,
            'title'   => 'Home',
            'page_id' => 1,
            'sort'    => 1,
            'active'  => 1,
        ]);
    }
}
