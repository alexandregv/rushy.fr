<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Post;

class PostsController extends Controller
{
    
    public function store(Request $request){
	$this->validate($request, [
		'titre' => ['required', 'string'],
		'label' => ['required', 'max:25'],
		'contenu' => ['required', 'string'],
		'image' => ['required', 'mimes:jpeg,png,jpg'],
	]);
        $post = Post::create(['title' => Input::get('titre'), 'label' => Input::get('label'), 'image' => Input::file('image'), 'content' => Input::get('contenu')]);
        
        return redirect()->route('admin.panel')->with('success', "L'article a bien été créé.");
    }
  
    public function delete(){
        if(Post::destroy(Input::get('postToDelete')) == 1) 
          return redirect()->route('admin.panel')->with('success', "L'article a été supprimé.");
        else
          return redirect()->route('admin.panel')->with('error', "Impossible de supprimer l'article.");
    }
    
}
