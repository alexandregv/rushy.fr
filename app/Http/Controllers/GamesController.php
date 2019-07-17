<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Game;

class GamesController extends Controller
{

    public function store(Request $request){
	$this->validate($request, [
		'newgame_name' => ['required', 'string'],
		'newgame_description' => ['required', 'string'],
		'newgame_image' => ['required', 'mimes:jpeg,png,jpg'],
	]);
        $game = Game::create(['name' => Input::get('newgame_name'), 'description' => Input::get('newgame_description'), 'image' => Input::file('newgame_image')]);

        return redirect()->route('admin.panel')->with('success', "Le jeu a bien été créé.");
    }
  
    public function delete(){
        if(Game::destroy(Input::get('gameToDelete')) == 1) 
          return redirect()->route('admin.panel')->with('success', "Le jeu a été supprimé.");
        else
          return redirect()->route('admin.panel')->with('error', "Impossible de supprimer le jeu.");
    }
    
}
