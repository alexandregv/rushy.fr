<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule as ValidationRule;
use App\Rule;
use DB;

class RulesController extends Controller
{

    public function store(Request $request){
	$this->validate($request, [
		'newrule_title' => ['required', 'string'],
		'newrule_content' => ['required', 'string'],
	]);
        $rule = Rule::create(['title' => Input::get('newrule_title'), 'content' => Input::get('newrule_content')]);
        return redirect()->route('admin.panel')->with('success', "La regle a bien été créée.");
    }

    public function update(){
			$id = Input::get('ruleToEdit');
			$rule = Rule::find($id);
			$rule->title = Input::get("editrule_title_$id");
			$rule->content = Input::get("editrule_content_$id");
			$rule->save();
      return redirect()->route('admin.panel')->with('success', "La regle a bien été modifiée.");
		}

    public function delete(){
        $res = Rule::destroy(Input::get('ruleToDelete'));
				
				DB::statement("ALTER TABLE `rules` DROP `id`");
				DB::statement("ALTER TABLE `rules` ADD `id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`id`);");

        if($res == 1)
          return redirect()->route('admin.panel')->with('success', "La regle a été supprimée.");
        else
          return redirect()->route('admin.panel')->with('error', "Impossible de supprimer la regle.");
    }

}
