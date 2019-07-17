 <html lang="fr">
  <head>
    @include('components.head')
  </head>
  
   <body id="particles-js" class="disallow-select">
    <div id="top"></div>
    <script src="/js/particles.min.js"></script>
    <script src="/js/particles.js"></script>
    
    @include('components.navbar')
    @include('components.flash')

    @yield('content')

    @include('components.footer')
    
    <script type="text/javascript">
      $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
      });
      $('.timeline-Header').ready(function(){
        $('#twitter-widget-0').contents().find("head").append($("<style type='text/css'>  .timeline-Header{display:none;}  </style>"));
      });
      var $route = $('html, body');
      $('a').click(function() {
          $route.animate({
              scrollTop: $( $.attr(this, 'href') ).offset().top
          }, 1000);
          return false;
      });
    </script>

  </body>
</html>
