<?php

use Illuminate\Database\Seeder;
use App\Album;
use App\Artist;
use App\Genre;
use App\History;
use App\Music;
use App\Nationality;
use App\Playlist;
use App\Spotify;
use App\User;

class DatabaseSeeder extends Seeder
{
  /**
     * Run the database seeds.
     *
     * @return void
     */
  public function run()
  {
    // $this->call('UsersTableSeeder');
    DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    factory(App\Album::class,10)->create();
    factory(App\Artist::class,10)->create();
    factory(App\Be::class,10)->create();
    factory(App\Belong::class,10)->create();
    factory(App\Compose::class,10)->create();
    factory(App\Contain::class,10)->create();
    factory(App\Genre::class,10)->create();
    factory(App\History::class,10)->create();
    factory(App\Hold::class,10)->create();
    factory(App\Includes::class,10)->create();
    factory(App\Music::class,10)->create();
    factory(App\Nationality::class,10)->create();
    factory(App\Playlist::class,10)->create();
    factory(App\Produce::class,10)->create();
    factory(App\Spotify::class,10)->create();
    factory(App\User::class,10)->create();

    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
}
