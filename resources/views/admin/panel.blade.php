@extends('admin.default')


@section('content')

<section class="header-panel">
  <div class="card">
    <div class="card-body">
       <div>
          <h5 class="card-title">Administration du site</h5>
       </div>
       <div>
         <a href="{{ route('admin.logout') }}" class="btn btn-danger">Déconnexion</a>
       </div>      
    </div>
  </div>
</section>

<section class="block-content row">
  <section class="content-panel col-12 col-md-12 col-sm-12 col-lg-8 col-xl-8 mt-2 mb-4">
    <!-- MAINTENANCE -->
    <div class="card">
      <div class="card-body">
         <h5 class="card-title">Mode maintenance</h5>
        <form method="post" action="{{ action('AdminController@toggleMaintenanceMode') }}" id="maintenanceForm">
          @csrf

          @if(App::isDownForMaintenance())
            <button type="submit" name="maintenancebtn" id="maintenancebtn" onclick="document.getElementById('maintenanceForm').submit();" class="form-control col-12 col-md-2 col-sm-12 col-sx-12 col-lg-2 btn btn-info mt-2">
              <i class="fas fa-exclamation-triangle"></i> Désactiver la maintenance <i class="fas fa-exclamation-triangle"></i>
            </button>
          @else
            <input type="text" name="message" id="message" class="form-control mt-2" autocomplete="off" placeholder="Message" value="">
            <input type="text" name="ipwhitelist" id="ipwhitelist" class="form-control mt-2" autocomplete="off" placeholder="IP autorisées: 127.0.0.1, {{ $ip }}" value="">
            <button type="submit" name="maintenancebtn" id="maintenancebtn" onclick="document.getElementById('maintenanceForm').submit();" class="form-control col-12 col-md-3 col-sm-12 col-sx-12 col-lg-3 btn btn-warning mt-2">
              <i class="fas fa-exclamation-triangle"></i> Activer la maintenance <i class="fas fa-exclamation-triangle"></i>
            </button>
          @endif

        </form>
      </div>
    </div>
    <!-- /MAINTENANCE -->
  </section>
  
  <section class="content-panel col-12 col-md-12 col-sm-12 col-lg-4 col-xl-4 mt-2 mb-4">
    <!-- CHANGER MDP -->
    <div class="card">
      <div class="card-body">
         <h5 class="card-title">Mot de passe</h5>
        <form method="post" action="{{ action('AdminController@changePassword') }}">
          @csrf
          <input type="password" name="password" id="password" class="form-control mt-2" autocomplete="new-password" placeholder="Nouveau mot de passe">
          <input type="password" name="password_confirmation" id="password_confirmation" class="form-control mt-2" autocomplete="off" placeholder="Confirmation nouveau mot de passe">
          <button type="submit" class="form-control col-12 col-md-8 col-sm-12 col-lg-6 btn btn-danger mt-2">
            <i class="fas fa-exclamation-triangle"></i> Changer le mot de passe <i class="fas fa-exclamation-triangle"></i>
          </button>
        </form>
      </div>
    </div>
    <!-- /CHANGER MDP -->
  </section>
  
  <section class="col-12 col-md-12 col-sm-12 col-lg-5 col-sx-12">
      <!-- YOUTUBE VIDEOS -->
      <div class="card">
        <div class="card-body">
           <h5 class="card-title">Changer la vidéo de la semaine</h5>
          <form method="post" action="{{ action('AdminController@updateVideo') }}">
            @csrf
            <input type="text" name="auteur" id="auteur" class="form-control" autocomplete="off" placeholder="Auteur" value="{{ old('auteur') }}">
            <input type="text" name="url" id="url" class="form-control mt-2" autocomplete="off" placeholder="URL embed (https://www.youtube.com/embed/xL4nj9XR2Rg)" value="{{ old('url') }}">
            <input type="submit" name="ytbtn" id="ytbtn" class="form-control col-12 col-md-3 col-sm-12 col-lg-3 btn btn-success mt-2" value="Changer la vidéo">
          </form>
          <hr>
          <u>Apercu:</u> (par <span id="previewauteur">{{ $video['auteur'] }}</span>)
          <div class="video-week">
            <div class="video">
              <iframe id="ytiframe" width="100%" height="100%" src="{{ $video['url'] }}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
            </div>
          </div>
        </div>
      </div>
      
      <script>
        $('#auteur').on('input propertychange paste', function() {
          document.getElementById('previewauteur').innerHTML=$('#auteur').val();
        });

        $('#url').on('input propertychange paste', function() {
          var iframe = document.getElementById('ytiframe');
          iframe.src = $('#url').val();
          iframe.src = iframe.src;
        });
      </script>
      
      <!-- /YOUTUBE VIDEO-->
  </section>
  
  <section class="col-12 col-md-12 col-sm-12 col-lg-7">
      <!-- Slogan rushy.fr -->
      <div class="card">
        <div class="card-body">
           <h5 class="card-title">Changer le slogan du site</h5>
          <form method="post" action="{{ action('AdminController@updateSlogan') }}">
            @csrf
            <input type="text" name="slogan" id="slogan" class="form-control" autocomplete="off" placeholder="Nouveau slogan" value="{{ old('slogan') }}">
            <input type="submit" name="sloganbtn" id="sloganbtn" class="form-control col-12 col-md-3 col-sm-12 col-lg-3 btn btn-success mt-2" autocomplete="off" value="Changer le slogan">
          </form>
          <hr>
          <u>Slogan actuel:</u>
          <div>
            {{ $slogan }}
          </div>
        </div>
      </div>
      <!-- /Slogan rushy.fr -->
      
      <!-- Staff membres -->
      <div class="card mt-4">
        <div class="card-body">
           <h5 class="card-title">Ajouter/Supprimer des membres dans le staff</h5>
          <form method="post" action="{{ action('AdminController@addStaff') }}">
            @csrf
            <input type="text" name="uuid" id="uuid" class="form-control mt-2" autocomplete="off" placeholder="Pseudo ou UUID" value="{{ old('uuid') }}">
            <select name="grade" class="form-control mt-2">
              <option value="nothing" id="nothing" selected>Grade</option>
              @foreach(array_keys($ranks) as $rank)
                <option value="{{ array_keys($ranks)[$loop->iteration-1] }}" @if(old('rank') == array_keys($ranks)[$loop->iteration-1]) selected @endif> {{ array_keys($ranks)[$loop->iteration-1] }} </option>
              @endforeach
            </select>
            <input type="submit" name="staffbtn" id="staffbtn" class="form-control col-12 col-md-3 col-sm-12 col-lg-3 btn btn-success mt-2" value="Ajouter un membre" onclick="document.getElementById('nothing').setAttribute('value', '')">
          </form>
          <hr>
          <u>Liste du staff:</u>
          <div>
            <form method="post" action="{{ action('AdminController@removeStaff') }}" id="deleteStaffForm">
              @csrf
              <input type="hidden" name="staffToDelete" value="">
              @foreach($staff as $member)
                <div class="chip" uuid="{{ $member->uuid }}" style=" color: {{ $ranks[$member->rank] }}; font-weight: 700;">
                  <img src="https://crafatar.com/avatars/{{ $member->uuid }}" alt="Person" width="96" height="96">
                  {{ $member->pseudo }} ({{ $member->rank }})
                  <span class="chipclosebtn" onclick="deleteStaff(this, '{{ $member->uuid }}');">&times;</span>
                </div>
              @endforeach
            </form>
          </div>
        </div>
      </div>
      <!-- /Staff membres-->
      
  </section>
  
  <section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Ajouter article -->
    <div class="card">
      <div class="card-body">
         <h5 class="card-title">Ajouter un article</h5>
        <form method="post" action="{{ action('PostsController@store') }}" enctype="multipart/form-data">
          @csrf
          <input type="text" name="titre" id="titre" class="form-control mt-2" autocomplete="off" placeholder="Titre">
          <input type="text" name="label" id="label" class="form-control mt-2" autocomplete="off" placeholder="Label">
          <div class="input-group mt-2">
            <div class="custom-file">
              <input type="file" name="image" id="image" class="custom-file-input">
              <label class="custom-file-label" for="image">Image</label>
            </div>
          </div>
          <textarea name="contenu" id="contenu" class="form-control mt-2" rows="10" placeholder="Contenu"></textarea>

          <input type="submit" name="articlebtn" id="articlebtn" class="form-control col-12 col-md-3 col-sm-12 col-sx-12 col-lg-3 btn btn-success mt-2" autocomplete="off" value="Ajouter un article">
        </form>
      </div>
    </div>
    <!-- /Ajouter article -->
  </section>

	<section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Liste articles -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Liste des articles</h5>
        <form method="post" action="{{ action('PostsController@delete') }}" id="deletePostForm">
          @csrf
          <input type="hidden" name="postToDelete" value="">
          <ul class="list-article">
            @foreach($posts as $post)
              <li>
                <div class="title-article">
                  {{ $post->title }}
                </div> 
                <div>
                  <button type="button" class="btn btn-danger" onclick="deletePost({{ $post->id }});" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Supprimer</b>"><i class="fas fa-trash-alt"></i></button>
                </div>
               </li>
            @endforeach
          </ul>
        </form>
      </div>
    </div>
    <!-- /Liste articles -->
  </section>

  <section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Ajouter jeu -->
    <div class="card">
      <div class="card-body">
         <h5 class="card-title">Ajouter un jeu</h5>
        <form method="post" action="{{ action('GamesController@store') }}" enctype="multipart/form-data">
          @csrf
          <input type="text" name="newgame_name" id="newgame_name" class="form-control mt-2" autocomplete="off" placeholder="Nom">
          <div class="input-group mt-2">
            <div class="custom-file">
              <input type="file" name="newgame_image" id="newgame_image" class="custom-file-input">
              <label class="custom-file-label" for="newgame_image">Image</label>
            </div>
          </div>
          <textarea name="newgame_description" id="newgame_description" class="form-control mt-2" rows="12" placeholder="Description"></textarea>

          <input type="submit" name="newgame_btn" id="newgame_btn" class="form-control col-12 col-md-3 col-sm-12 col-sx-12 col-lg-3 btn btn-success mt-2" autocomplete="off" value="Ajouter un jeu">
        </form>
      </div>
    </div>
    <!-- /Ajouter jeu -->
  </section>

  <section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Liste jeux -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Liste des jeux</h5>
        <form method="post" action="{{ action('GamesController@delete') }}" id="deleteGameForm">
          @csrf
          <input type="hidden" name="gameToDelete" value="">
          <ul class="list-article">
            @foreach($games as $game)
              <li>
                <div class="title-article">
                  {{ $game->name }}
                </div> 
                <div>
                  <button type="button" class="btn btn-danger" onclick="deleteGame({{ $game->id }});" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Supprimer</b>"><i class="fas fa-trash-alt"></i></button>
                </div>
               </li>
            @endforeach
          </ul>
        </form>
      </div>
    </div>
    <!-- /Liste jeux -->
  </section>

	<section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Ajouter regle -->
    <div class="card">
      <div class="card-body">
         <h5 class="card-title">Ajouter une regle</h5>
        <form method="post" action="{{ action('RulesController@store') }}" enctype="multipart/form-data">
          @csrf
          <input type="text" name="newrule_title" id="newrule_title" class="form-control mt-2" autocomplete="off" placeholder="Titre">
          <textarea name="newrule_content" id="newrule_content" class="form-control mt-2" rows="12" placeholder="Contenu"></textarea>

          <input type="submit" name="newrule_btn" id="newrule_btn" class="form-control col-12 col-md-3 col-sm-12 col-sx-12 col-lg-3 btn btn-success mt-2" autocomplete="off" value="Ajouter une regle">
        </form>
      </div>
    </div>
    <!-- /Ajouter regle -->
  </section>

  <section class="col-12 col-md-12 col-sm-12 col-lg-6 col-xl-6 mt-4">
    <!-- Liste regles -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Liste des regles</h5>
        <form method="post" action="{{ action('RulesController@delete') }}" id="deleteRuleForm">
          @csrf
          <input type="hidden" name="ruleToDelete" value="">
          <ul class="list-article">
            @foreach($rules as $rule)
              <li>
                <div class="title-article">
                  {{ $rule->id }}. {{ $rule->title }}
                </div>
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-rule-{{ $rule->id }}" title="Modifier"><i class="fas fa-pen"></i></button>
                <button type="button" class="btn btn-danger" onclick="deleteRule({{ $rule->id }});" data-toggle="tooltip" data-placement="right" data-html="true" title="<b>Supprimer</b>"><i class="fas fa-trash-alt"></i></button>
              </li>
            @endforeach
          </ul>
        </form>
      </div>
    </div>
    <!-- /Liste regles -->
  </section>


</section>

<!-- Rules Modals -->
@foreach($rules as $rule)
  <div class="modal fade" id="modal-rule-{{ $rule->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title title-aritcle-modal">Modifier une regle</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"><i class="fas fa-times" style="margin-top: 0.4rem;"></i></span>
          </button>
        </div>

        <div class="modal-body content-article-modal">
					<form method="post" action="{{ action('RulesController@update') }}" enctype="multipart/form-data" id="editRuleForm_{{ $rule->id }}">
						@csrf
          	<input type="hidden" name="ruleToEdit" value="{{ $rule->id }}">
						<input type="text" name="editrule_title_{{ $rule->id }}" id="editrule_title_{{ $rule->id }}" class="form-control mt-2" autocomplete="off" placeholder="Titre" value="{{ $rule->title }}">
						<textarea name="editrule_content_{{ $rule->id }}" id="editrule_content_{{ $rule->id }}" class="form-control mt-2" rows="12" placeholder="Contenu">{{ $rule->content }}</textarea>
						<br>
            <button type="submit" class="btn btn-info"><b>Modifier</b></button>
					</form>
        </div>
        <div class="modal-footer">
          <i>Derniere modification le {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $rule->updated_at)->format('d/m/Y') }}</i>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
@endforeach


<script>
  
  function deleteStaff(elem, uuid){
    form = document.getElementById('deleteStaffForm');
    elem.parentElement.style.display='none';
    form.elements['staffToDelete'].setAttribute('value', uuid);
    form.submit();
  }

  function deletePost(id){
    form = document.getElementById('deletePostForm');
    form.elements['postToDelete'].setAttribute('value', id);
    form.submit();
  }
	
  function deleteGame(id){
    form = document.getElementById('deleteGameForm');
    form.elements['gameToDelete'].setAttribute('value', id);
    form.submit();
  }

  function deleteRule(id){
    form = document.getElementById('deleteRuleForm');
    form.elements['ruleToDelete'].setAttribute('value', id);
    form.submit();
  }

</script>

@endsection
