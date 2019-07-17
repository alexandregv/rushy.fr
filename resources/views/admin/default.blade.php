 <html lang="fr">
  <head>
    @include('components.head')
  </head>
  
   <body class="">
        
    @include('components.navbar')
    @include('components.flash')

    @yield('content')
    
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>

  </body>
</html>