<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\{Post, Game, Rule};
use Artisan;
use DB;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller {

    public function index()
    {
      $page = 'Accueil';
      $slogan = DB::table('vars')->select('value')->where('name', 'slogan')->first()->value;
      $posts = Post::orderBy('id', 'DESC')->take(3)->get();
      $video = DB::table('vars')->select('value')->where('name', 'yturl')->orWhere('name', 'ytauteur')->get();
      $video = ['auteur' => $video[0]->value, 'url' => $video[1]->value];
      return view('pages.index', ['page' => $page, 'slogan' => $slogan, 'posts' => $posts, 'video' => $video]);
    }
 
    public function jeux()
    {
      $page = 'Jeux';  
      $games = Game::orderBy('id', 'DESC')->get();
      return view('pages.jeux', ['page' => $page, 'games' => $games]);
    }

    public function reglement()
    {
			$page = 'Reglement';
			$rules = Rule::all();
      return view('pages.reglement', ['page' => $page, 'rules' => $rules]);
    }

    public function staff()
    {
      $page = 'Staff';  
      $staffs = DB::table('staff')->select('pseudo', 'uuid', 'rank')->get();
      return view('pages.staff', ['page' => $page, 'staffs' => $staffs, 'ranks' => $this->ranks]);
    }

    public function boutique()
    {
      $page = 'Boutique';  
      return view('pages.boutique', ['page' => $page]);
    }

    public function cgu()
    {
      $page = 'CGU';  
      return view('pages.cgu', ['page' => $page]);
    }

    public function cgv()
    {
      $page = 'CGV';  
      return view('pages.cgv', ['page' => $page]);
    }

    public function bug(Request $request)
    {
      $this->validate($request, [
               'pseudo' =>  ['required', 'min:3'],
               'sujet' => ['required', 'min:5'],
               'mail' => ['required', 'email'],
               'message' => ['required', 'min:20']
      ]);

      $args = ['pseudo' => Input::get('pseudo'),
               'subject' => Input::get('sujet'),
               'from' => Input::get('mail'),
               'content' => Input::get('message')
              ];

      Mail::send('emails.contact', $args, function($message) use ($args){
        $message->to('contact@rushy.fr')->subject("[BUG] " . $args['subject']);
      });

      if(count(Mail::failures()) <= 0) return back()->with('success', "Le bug a été signalé, merci!");
      else return back()->with('error', "Une erreur est survenue.");
    }

	public function OLD_stats($username = null)
    {
      $page = 'Statistiques';

      if($username)
      {
        $uuid = null;
        if (is_valid_username($username))
        {
          $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $username);
          if (!empty($json))
          {
            $data = json_decode($json, true);
            if (is_array($data) and !empty($data)) $uuid = $data['id'];
          }
        }

        if($uuid != null){
          $stats_rushbox_all  = DB::table('stats_rushbox')->orderBy(DB::raw('kills/deaths'), 'DESC')->get();
          $stats_rtf_all      = DB::table('stats_rtf')->orderBy(DB::raw('wins/loses'), 'DESC')->get();
          $stats_rushzone_all = DB::table('stats_rushzone')->orderBy(DB::raw('wins/loses'), 'DESC')->get();

          $stats_rushbox  = $stats_rushbox_all->where('uuid', $uuid)->first();
          $stats_rtf      = $stats_rtf_all->where('uuid', $uuid)->first();
          $stats_rushzone = $stats_rushzone_all->where('uuid', $uuid)->first();

          if($stats_rushbox == null && $stats_rtf == null && $stats_rushzone == null)
            return redirect()->route('stats')->with('error', "Impossible de trouver ce joueur.");

          $pos_rushbox = array_search($stats_rushbox, $stats_rushbox_all->toArray())+1;
          $pos_rtf = array_search($stats_rtf, $stats_rtf_all->toArray())+1;
          $pos_rushzone = array_search($stats_rushzone, $stats_rushzone_all->toArray())+1;

          return view('pages.user-stats', ['page' => $page, 'stats_rushbox' => $stats_rushbox, 'stats_rtf' => $stats_rtf, 'stats_rushzone' => $stats_rushzone, 'pos_rushbox' => $pos_rushbox, 'pos_rtf' => $pos_rtf, 'pos_rushzone' => $pos_rushzone]);
        }
        else return redirect()->route('stats')->with('error', "Impossible de trouver ce joueur.");
      }

      $stats_rushbox  = DB::table('stats_rushbox')->orderBy(DB::raw('kills/deaths'), 'DESC')->limit(25)->get();
      $stats_rtf      = DB::table('stats_rtf')->orderBy(DB::raw('wins/loses'), 'DESC')->limit(25)->get();
      $stats_rushzone = DB::table('stats_rushzone')->orderBy(DB::raw('wins/loses'), 'DESC')->limit(25)->get();
      return view('pages.stats', ['page' => $page, 'stats_rushbox' => $stats_rushbox, 'stats_rtf' => $stats_rtf, 'stats_rushzone' => $stats_rushzone]);
    }

	public function stats($username = null)
    {
      $page = 'Statistiques';

      if(isset($username))
      {

	  	if (empty(cache('stats_rushbox_all')) || empty(cache('stats_rush_all')) || empty(cache('stats_rtf_all')) || empty(cache('user_stats_rushbox_' . $username)) || empty(cache('user_stats_rush_' . $username)) || empty(cache('user_stats_rtf_' . $username)))
		{
          $conn = DB::connection('mysql_stats');

		  //$need_to_cache = false;
		  //if (empty(cache('stats_rushbox_all')) || empty(cache('stats_rush_all')) || empty(cache('stats_rtf_all')))
		  //{
	        $stats_rushbox_all = $conn->table('webStats')->select('name', 'rushbox_kills AS kills', 'rushbox_deaths AS deaths', DB::raw('rushbox_kills/GREATEST(rushbox_deaths, 1) AS KD'))->orderBy('kills', 'DESC');
	        $stats_rush_all    = $conn->table('webStats')->select('name', 'rush_kills AS kills', 'rush_deaths AS deaths', DB::raw('rush_kills/GREATEST(rush_deaths, 1) AS KD'))->orderBy('KD', 'DESC');
            // OLD SCORE $stats_rtf_all     = $conn->table('webStats')->select('name', 'rtf_kills AS kills', 'rtf_deaths AS deaths', 'rtf_wins AS wins', 'rtf_loses AS loses', DB::raw('rtf_kills/GREATEST(rtf_deaths, 1) AS KD'), DB::raw('LEAST(rtf_wins/(rtf_wins+rtf_loses) * 100, 100) AS winrate'), DB::raw('((rtf_wins * 10 + rtf_kills * 2) - (rtf_loses + rtf_deaths)) AS score'))->orderBy('score', 'DESC');
            $stats_rtf_all     = $conn->table('webStats')->select('name', 'rtf_kills AS kills', 'rtf_deaths AS deaths', 'rtf_wins AS wins', 'rtf_loses AS loses', DB::raw('rtf_kills/GREATEST(rtf_deaths, 1) AS KD'), DB::raw('LEAST(rtf_wins/(rtf_wins+rtf_loses) * 100, 100) AS winrate'), DB::raw('((rtf_wins * 10) + rtf_kills - rtf_deaths) AS score'))->orderBy('score', 'DESC');


			//$need_to_cache = true;
		  //}
         // else
		 // {
      	 //   $stats_rushbox_all = cache('stats_rushbox_all'); 
      	 //   $stats_rush_all    = cache('stats_rush_all'); 
      	 //   $stats_rtf_all     = cache('stats_rtf_all'); 
		 // }

          $stats_rushbox     = (clone $stats_rushbox_all)->whereRaw('LOWER(name) LIKE (?)', [strtolower($username)])->first();
          $stats_rush        = (clone $stats_rush_all)->whereRaw('LOWER(name) LIKE (?)', [strtolower($username)])->first();
          $stats_rtf         = (clone $stats_rtf_all)->whereRaw('LOWER(name) LIKE (?)', [strtolower($username)])->first();

      	  $stats_rushbox_all = $stats_rushbox_all->get();
      	  $stats_rush_all    = $stats_rush_all->get();
      	  $stats_rtf_all     = $stats_rtf_all->get();

		  //if ($need_to_cache === true)
		  //{
 		  //  cache(['stats_rushbox_all' => $stats_rushbox_all], now()->addHours(1));
 		  //  cache(['stats_rush_all' => $stats_rush_all], now()->addHours(1));
 		  //  cache(['stats_rtf_all' => $stats_rtf_all], now()->addHours(1));
		  //}

          if($stats_rushbox == null && $stats_rush == null && $stats_rtf == null)
            return redirect()->route('stats')->with('error', "Impossible de trouver ce joueur.");

          $pos_rushbox = array_search($stats_rushbox, $stats_rushbox_all->toArray()) + 1;
          $pos_rush    = array_search($stats_rush, $stats_rush_all->toArray()) + 1;
          $pos_rtf     = array_search($stats_rtf, $stats_rtf_all->toArray()) + 1;

/*
		  cache([
			'stats_rushbox_all' => $stats_rushbox_all,
			'stats_rtf_all' => $stats_rtf_all,
			'user_stats_rushbox_' . $username => $stats_rushbox,
			'user_stats_rtf_' . $username => $stats_rtf
		  ], now()->addHours(1));
*/
 		  cache(['user_stats_rushbox_' . $username => $stats_rushbox], now()->addHours(1));
 		  cache(['user_stats_rush_' . $username => $stats_rush], now()->addHours(1));
 		  cache(['user_stats_rtf_' . $username => $stats_rtf], now()->addHours(1));
		}
		else
      	{
	  	  $stats_rushbox_all	= cache('stats_rushbox_all');
	  	  $stats_rush_all		= cache('stats_rush_all');
	  	  $stats_rtf_all		= cache('stats_rtf_all');
	  	  $stats_rushbox		= cache('user_stats_rushbox_' . $username);
	  	  $stats_rush			= cache('user_stats_rush_' . $username);
	  	  $stats_rtf			= cache('user_stats_rtf_' . $username);

          $pos_rushbox = array_search($stats_rushbox, $stats_rushbox_all->toArray()) + 1;
          $pos_rush    = array_search($stats_rush, $stats_rush_all->toArray()) + 1;
          $pos_rtf     = array_search($stats_rtf, $stats_rtf_all->toArray()) + 1;
	  	}

        return view('pages.user-stats', ['page' => $page, 'stats_rushbox' => $stats_rushbox, 'stats_rush' => $stats_rush,'stats_rtf' => $stats_rtf, 'pos_rushbox' => $pos_rushbox, 'pos_rush' => $pos_rush, 'pos_rtf' => $pos_rtf]);
      }

	  if (empty(cache('stats_rushbox')) || empty(cache('stats_rush')) || empty(cache('stats_rtf')) || empty(cache('dieux')))
	  {
        $conn = DB::connection('mysql_stats');
	    $stats_rushbox  = $conn->table('webStats')->select('name', 'rushbox_kills AS kills', 'rushbox_deaths AS deaths', DB::raw('rushbox_kills/GREATEST(rushbox_deaths, 1) AS KD'))->orderBy('kills', 'DESC')->limit(25)->get();
	    $stats_rush     = $conn->table('webStats')->select('name', 'rush_kills AS kills', 'rush_deaths AS deaths', DB::raw('rush_kills/GREATEST(rush_deaths, 1) AS KD'))->orderBy('KD', 'DESC')->limit(25)->get();
        // OLD SCORE $stats_rtf      = $conn->table('webStats')->select('name', 'rtf_kills AS kills', 'rtf_deaths AS deaths', 'rtf_wins AS wins', 'rtf_loses AS loses', DB::raw('rtf_kills/GREATEST(rtf_deaths, 1) AS KD'), DB::raw('LEAST(rtf_wins/(rtf_wins+rtf_loses) * 100, 100) AS winrate'), DB::raw('((rtf_wins * 10 + rtf_kills * 2) - (rtf_loses + rtf_deaths)) AS score'))->orderBy('score', 'DESC')->limit(25)->get();
        $stats_rtf      = $conn->table('webStats')->select('name', 'rtf_kills AS kills', 'rtf_deaths AS deaths', 'rtf_wins AS wins', 'rtf_loses AS loses', DB::raw('rtf_kills/GREATEST(rtf_deaths, 1) AS KD'), DB::raw('LEAST(rtf_wins/(rtf_wins+rtf_loses) * 100, 100) AS winrate'), DB::raw('((rtf_wins * 10) + rtf_kills - rtf_deaths) AS score'))->orderBy('score', 'DESC')->limit(25)->get();
        $dieux          = [
	      ['text' => 'de la Rushbox',  'data' => $conn->table('webStats')->select('name', DB::raw('rushbox_kills AS kills'))->orderBy(DB::raw('kills'), 'DESC')->first()],
	      ['text' => 'du RushTheFlag', 'data' => $conn->table('webStats')->select('name', DB::raw('rtf_kills AS kills')    )->orderBy(DB::raw('kills'), 'DESC')->first()]
	    ];

	    foreach($dieux as $dieu)
	    {
          $dieu['data']->uuid = '8667ba71b85a4004af54457a9734eed7';
          if (is_valid_username($dieu['data']->name))
          {
            $json = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $dieu['data']->name);
            if (!empty($json))
            {
              $data = json_decode($json, true);
              if (is_array($data) and !empty($data))
	      	    $dieu['data']->uuid = $data['id'];
	      	}
          }
	    }
	    //cache(['stats_rushbox' => $stats_rushbox, 'stats_rtf' => $stats_rtf, 'dieux' => $dieux], now()->addHours(1));
	    cache(['stats_rushbox' => $stats_rushbox], now()->addHours(1));
	    cache(['stats_rush' => $stats_rush], now()->addHours(1));
	    cache(['stats_rtf' => $stats_rtf], now()->addHours(1));
	    cache(['dieux' => $dieux], now()->addHours(1));
	  }
	  else
      {
	    $stats_rushbox	= cache('stats_rushbox');
	    $stats_rush   	= cache('stats_rush');
	    $stats_rtf		= cache('stats_rtf');
	    $dieux			= cache('dieux');
	  }

      return view('pages.stats', [
		'page' => $page,
		'stats_rushbox' => $stats_rushbox,
		'stats_rush' => $stats_rush,
		'stats_rtf' => $stats_rtf,
		'dieux' => $dieux
	  ]);
    }

}
