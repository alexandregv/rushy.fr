 <html lang="fr">
  <head>
    @include('components.head')
  </head>
  
   <body id="particles-js" class="disallow-select error-pages">
    <script src="{{ asset('/js/particles.min.js') }}"></script>
    <script src="{{ asset('/js/particles.js') }}"></script>
    
    @include('components.navbar')

    <section class="header-homepages">
      <div class="block-title">
        <span class="error-title">@yield('error', "Erreur")</span>
        <div class="error-subtitle">@yield('message', "Il semble qu'une erreur se soit produite...")</div>
      </div>
    </section>
    <div style="position: fixed; bottom: 0; width: 101%;">
      @include('components.footer')
    </div>
    
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>
  </body>
</html>