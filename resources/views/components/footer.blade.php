<section class="footer-block">
	<div class="block-footer">
		<div class="links-social">
			<div>
				<h1>Rushy.fr</h1>
			</div>
			<div class="socials-btn">
				<a href="http://rushy.fr/discord" target="_blank" id="discord"><i class="fab fa-discord"></i></a>
				<a href="https://twitter.com/RushyFR" target="_blank" id="twitter"><i class="fab fa-twitter"></i></a>
			</div>	
		</div>
		<div class="logo-footer">
			<a href="#top"><img src="/img/logo.png"></a>
		</div>
		<div class="twitter-footer">
			<a class="twitter-timeline" data-width="500" data-height="200" data-dnt="true" data-link-color="#2B7BB9" href="https://twitter.com/RushyFR?ref_src=twsrc%5Etfw"></a> 
			<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
	</div>
	<hr class="hr-footer">
	<div class="credits-line">
		<div class="link-footer">
			<span><i class="far fa-copyright"></i> rushy.fr 2019. All rights reserved</span>
		</div>
		<div class="circle-footer">
            <i class="fas fa-circle"></i>
		</div>
		<div class="link-footer">
			<a href="https://github.com/alexandregv/rushy.fr" target="_blank">GitHub</a>
		</div>
		<div class="circle-footer">
			<i class="fas fa-circle"></i>
		</div>
		<div class="link-footer">
			<a href="" data-toggle="modal" data-target="#devmodal">Développeurs</a>
		</div>
		<div class="circle-footer">
			<i class="fas fa-circle"></i>
		</div>
		<div class="link-footer">
			<a href={{ route('cgu') }}>CGU</a>
		</div>
		<div class="circle-footer">
			<i class="fas fa-circle"></i>
		</div>
		<div class="link-footer">
			<a href={{ route('cgv') }}>CGV</a>
		</div>
		<div class="circle-footer">
			<i class="fas fa-circle"></i>
		</div>
		<div class="link-footer">
			<a href="" data-toggle="modal" data-target="#bugModal">Signaler un bug</a>
		</div>
	</div>
</section>

<!-- Modal credits-->
<div class="modal fade" id="devmodal" tabindex="-1" role="dialog" aria-labelledby="devmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Crédits</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="dev-list">
        	<div class="dev">
        		<div class="dev-logo">
        			<img src="/img/logo_mrtwizard.png">
        		</div>
        		<div class="dev-pseudo">
        			<a href="https://mrtwizard.fr/" target="_blank">mrtwizard</a>
        			<span>Développeur frontend</span>
        		</div>
        		<div class="dev-links">
        			<a href="https://twitter.com/mrtwizard" target="_blank" id="twitter"><i class="fab fa-twitter"></i></a>
        			<a href="https://github.com/baptiste-mrt" target="_blank" id="github"><i class="fab fa-github"></i></a>
        		</div>
        	</div>

        	<div class="dev">
        		<div class="dev-logo">
        			<img src="/img/logo_triinoxys.png">
        		</div>
        		<div class="dev-pseudo">
        			<a href="https://triinoxys.fr/" target="_blank">triinoxys</a>
        			<span>Développeur backend</span>
        		</div>
        		<div class="dev-links">
        			<a href="https://twitter.com/triinoxys" target="_blank" id="twitter"><i class="fab fa-twitter"></i></a>
        			<a href="https://github.com/alexandregv" target="_blank" id="github"><i class="fab fa-github"></i></a>
        		</div>
        	</div>
        	
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal Bug-->
<div class="modal fade bd-example-modal-lg" id="bugModal" tabindex="-1" role="dialog" aria-labelledby="bugModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Signaler un bug</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ action('PagesController@bug') }}">
          @csrf
          <input type="hidden" name="openbugmodal" id="openbugmodal" value="{{ old('openbugmodal') }}">
          <input type="text" name="pseudo" id="pseudo" class="form-control mt-2" autocomplete="off" placeholder="Pseudo" value="{{ old('pseudo') }}">
          <input type="mail" name="mail" id="mail" class="form-control mt-2" placeholder="Mail" value="{{ old('mail') }}">
          <input type="text" name="sujet" id="sujet" class="form-control mt-2" autocomplete="off" placeholder="Sujet" value="{{ old('sujet') }}">
          <textarea name="message" id="message" class="form-control mt-2" rows="16" placeholder="Message">{{ old('message') }}</textarea>
          <input type="submit" name="bugreportbtn" id="bugreportbtn" class="form-control col-12 col-md-3 col-sm-12 col-sx-12 col-lg-3 btn btn-success mt-2" value="Envoyer le message" onclick="document.getElementById('openbugmodal').setAttribute('value', 'true');">
        </form>
      </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
    if(document.getElementById('openbugmodal').getAttribute('value') == 'true'){
      $('#bugModal').modal('show');
    }
  });
</script>
