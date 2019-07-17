<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Storage;
use App;
use App\{Post, Game, Rule};
use Artisan;

class AdminController extends Controller {
  
  public function panel(Request $request)
  {
    $page = 'Panel admin';
    $video = DB::table('vars')->select('value')->where('name', 'yturl')->orWhere('name', 'ytauteur')->get();
    $video = ['auteur' => $video[0]->value, 'url' => $video[1]->value];
    $slogan = DB::table('vars')->select('value')->where('name', 'slogan')->first()->value;
    $staff = DB::table('staff')->select('pseudo', 'uuid', 'rank')->get();
    $posts = Post::orderBy('created_at', 'DESC')->get();
    $games = Game::orderBy('created_at', 'DESC')->get();
    $rules = DB::table('rules')->select('id', 'title', 'content')->get();
    $rules = Rule::all();
    $ip = $request->getClientIp();
    return view('admin.panel', ['page' => $page, 'video' => $video, 'slogan' => $slogan, 'ranks' => $this->ranks, 'staff' => $staff, 'posts' => $posts, 'games' => $games, 'ip' => $ip, 'rules' => $rules]);
  }

  public function showLoginForm()
  {
    $page = 'Accès admin';
    return view('admin.login', ['page' => $page]);
  }

  public function login(Request $request)
  {
    $this->validate($request, [
        'password' => 'required',
        'g-recaptcha-response' => ''
    ]);
    
    $hash = DB::table('vars')->select('value')->where('name', 'adminpass')->first()->value;
    
    if(Hash::check(Input::get('password'), $hash)){
      Session::put('admin', 'true'); 
      return redirect()->route('admin.panel')->with('success', 'Connexion réussie.');
    }
    else return redirect()->route('admin.login')->with('error', 'Mot de passe incorrect.');
  }

  public function logout()
  {
    Session::forget('admin'); 
    return redirect()->route('index')->with('success', 'Vous avez été déconnecté.');
  }
  
  public function updateVideo(Request $request)
  {  
    $this->validate($request, [
        'auteur' => ['required', 'alpha_num', 'max:32'],
        'url' => ['required', 'regex:/^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9-_]+$/']
    ]);
    
    if(DB::table('vars')->where('name', 'yturl')->update(['value' => Input::get('url')]) == 1 
       && DB::table('vars')->where('name', 'ytauteur')->update(['value' => Input::get('auteur')]) == 1)
      return redirect()->route('admin.panel')->with('success', 'La vidéo a été changée.');
    else
      return back()->withInput()->with('success', 'Impossible de modifier la vidéo.');
  }
  
  public function updateSlogan(Request $request)
  {
    $this->validate($request, [
        'slogan' => 'required'
    ]);
    
    if(DB::table('vars')->where('name', 'slogan')->update(['value' => Input::get('slogan')]) == 1)
      return redirect()->route('admin.panel')->with('success', 'Le slogan a été changé.');
    else
      return back()->withInput()->with('error', 'Impossible de modifier le slogan.');
  }
  
  public function addStaff(Request $request)
  {
    $this->validate($request, [
        'uuid' => ['required', 'alpha_dash', 'min:2'],
        'grade' => ['required', ValidationRule::in(array_keys($this->ranks))]
    ]);
    
    $uuid = Input::get('uuid');
    
    if(strlen($uuid) <= 16){ // UUID = Pseudo
      if(is_valid_username($uuid))
        $uuid  = username_to_uuid($uuid);
      else return back()->withInput()->with('error', "Le pseudo est invalide.");
    }
    
    if(DB::table('staff')->insert(['pseudo' => uuid_to_username($uuid), 'uuid' => minify_uuid($uuid), 'rank' => Input::get('grade')]) == 1)
      return redirect()->route('admin.panel')->with('success', 'Le membre a été ajouté.');
    else
      return back()->withInput()->with('error', "Impossible d'ajouter le membre.");
  }

  public function removeStaff()
  {  
    if(DB::table('staff')->where('uuid', Input::get('staffToDelete'))->delete() >= 1)
      return redirect()->route('admin.panel')->with('success', 'Le membre a été supprimé.');
    else
      return back()->withInput()->with('error', 'Impossible de supprimer le membre.');
  }
  
  public function toggleMaintenanceMode(Request $request)
  {  
    if(App::isDownForMaintenance()){
      if(Artisan::call('up') == 0){
        Storage::put('ipwhitelist.json', '{}');
        return redirect()->route('admin.panel')->with('success', "Le site n'est plus en maintenance.");
      }
      else
        return back()->withInput()->with('error', "Impossible de désactiver le mode maintenance.");
    }
    else{
      $ips = explode(",", preg_replace('/\s+/', '', Input::get('ipwhitelist')));
      array_push($ips, $request->getClientIp());
      Storage::put('ipwhitelist.json', json_encode($ips));
      
      if(Artisan::call('down', ['--message' => Input::get('message')]) == 0)
        return redirect()->route('admin.panel')->with('success', 'Le site est désormais en maintenance.');
      else
        return back()->withInput()->with('error', "Impossible d'activer le mode maintenance.");
    }
  }
  
  public function changePassword(Request $request)
  {
    $this->validate($request, [
        'password' => ['required',
                       'min:6',
                       'confirmed',
                       'regex:/^.*(?=.{1,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\x]).*$/'] // a-Z, 0-9, non-alpha (!,$,#,%) (au moins 1 min, 1 maj et 1 nombre)
    ]);
    
    $hash = Hash::make(Input::get('password'));
    
    if(DB::table('vars')->where('name', 'adminpass')->update(['value' => $hash]) == 1)
      return redirect()->route('admin.panel')->with('success', 'Le mot de passe a été changé.');
    else
      return back()->withInput()->with('error', 'Impossible de modifier le mot de passe.');
  }

/*  
public function addGame(Request $request)
  {
	$this->validate($request, ['newgame_name' => ['required']]);
    $name = Input::get('newgame_name');
    
    if(DB::table('games')->insert(['pseudo' => uuid_to_username($uuid), 'uuid' => minify_uuid($uuid), 'rank' => Input::get('grade')]) == 1)
      return redirect()->route('admin.panel')->with('success', 'Le membre a été ajouté.');
    else
      return back()->withInput()->with('error', "Impossible d'ajouter le jeu.");
  }
*/
}
