<?php

namespace App\Http\Controllers;

use App\Artist;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArtistController extends Controller{
	/*
	//Artist constructor
	public function __construct(){
		$this->middleware('oauth', ['except' => ['getAllArtists', 'getArtist']]);
		$this->middleware('authorize:' . __CLASS__, ['except' => ['getAllArtists', 'getArtist', 'createArtist']]);
	}
	*/

	/*----------------------------Basic functions--------------------------*/

	//get All Artists
	public function getAllArtists(){
		$artists = Artist::all();

        return response()->json(['data' => $artists], 200);
	}

	//create Artist
	public function createArtist(Request $request){
		$this->validateRequestArtist($request);

		$artist = Artist::create([
			'artist_name' => $request->get('artist_name'),
			'artist_birth_year' => $request->get('artist_birth_year'),
			'artist_death_year' => $request->get('artist_death_year')
		]);

        return response()->json(['data' => "The artist with id {$artist->artist_id_artist} has been created"], 201);
	}

	//get Artist
	public function getArtist($id){
		$artist = Artist::find($id);

		if(!$artist)
            return response()->json(['message' => "The artist with id {$id} doesn't exist"], 404);

        return response()->json(['data' => $artist], 200);
	}

	//update Artist
	public function updateArtist(Request $request, $id){
		$artist = Artist::find($id);

		if(!$artist)
	        return response()->json(['message' => "The artist with id {$id} doesn't exist"], 404);

		$this->validateRequestArtist($request);

		$artist->artist_name = $request->get('artist_name');
		$artist->artist_birth_year = $request->get('artist_birth_year');
		$artist->artist_death_year = $request->get('artist_death_year');

		$artist->save();

	    return response()->json(['data' => "The artist with id {$artist->artist_id_artist} has been updated"], 200);
	}

	//delete Artist
	public function deleteArist($id){
		$artist = Artist::find($id);

		if(!$artist)
			return response()->json(['message' => "The artist with id {$id} doesn't exist"], 404);

		$artist->delete();

		return response()->json(['data' => "The artist with id {$id} has been deleted"], 200);
	}

	/*----------------------------Stats functions--------------------------*/
	//Get the list of all albums of one Artist
	public function getAlbumListOfArtist($id_artist){
		$albums = DB::table('albums')
		->join('produce', 'albums.album_id_album', '=', 'produce.album_id_album')
		->join('artists', 'artists.artist_id', '=', 'produce.artist_id_artist')
		->select('albums.*', 'artists.artist_id', 'artists.artist_name')
		->where('artists.artist_id', '=', $id_artist)
		->get();

		return $this->success($albums, 200);
	}

	//Get the artists the most listened by all users
	public function getArtistsMostListened(){
		$artists = DB::table('user')
		->join('histories', 'user.id', '=', 'histories.user_id_user')
		->join('contain', 'histories.history_id_history', '=', 'contain.history_id_history')
		->join('music', 'contain.music_id_music', '=', 'music.music_id_music')
		->join('compose', 'music.music_id_music', '=', 'compose.music_id_music')
		->join('artists', 'compose.artist_id_artist', '=', 'artists.artist_id')
		->select('artists.artist_name', 'COUNT(artists.artist_id) as nbListening')
		->groupBy('artists.artist_id')
		->orderBy('nbListening DESC')
		->get();

		return $this->success($artists, 200);		
	}

	//Get the artists the most listened by a specific user
	public function getArtistsMostListenedByUser($id_user){
		$artists = DB::table('user')
		->join('histories', 'user.id', '=', 'histories.user_id_user')
		->join('contain', 'histories.history_id_history', '=', 'contain.history_id_history')
		->join('music', 'contain.music_id_music', '=', 'music.music_id_music')
		->join('compose', 'music.music_id_music', '=', 'compose.music_id_music')
		->join('artists', 'compose.artist_id_artist', '=', 'artists.artist_id')
		->select('user.username', 'user.id', 'COUNT(artists.artist_id) as nbListening')
		->where('user.id', '=', $id_user)
		->groupBy('artists.artist_id')
		->orderBy('nbListening DESC')
		->get();

		return $this->success($artists, 200);
	}

	//Get the artists the most listened in a specific genre by all user
	public function getArtistsMostListenedOfGenre($id_genre){
		$artists = DB::table('genre')
		->join('be', 'genre.genre_id_genre', '=', 'be.genre_id_genre')
		->join('music', 'be.music_id_music', '=', 'music.music_id_music')
		->join('compose', 'music.music_id_music', '=', 'compose.music_id_music')
		->join('artists', 'compose.artist_id_artist', '=', 'artists.artist_id')
		->select('artists.artist_name', 'COUNT(artists.artist_id) as nbListening')
		->where('genre.genre_id_genre', '=', $id_genre)
		->groupBy('artists.artist_name')
		->orderBy('nbListening DESC')
		->get();

		return $this->success($artists, 200);
	}

	/*----------------------------Annex functions--------------------------*/

	//validate request artist
	public function validateRequestArtist(Request $request){
		$rules = [
			'artist_name' => 'required',
			'artist_birth_year' => 'required|numeric',
			'artist_death_year' => 'required|numeric'
		];

		$this->validate($request, $rules);
	}

	//is authorized
	public function isAuthorizedArtist(Request $request){
		$resource = "artists"; 
		$artist = Artist::find($this->getArgs($request)["artist_id_artist"]);

		return $this->authorizeUser($request, $resource, $artist);
	}
	//
	
}

?>