<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link rel="icon" href="/img/logo.png" type="image/x-icon" />
<link rel="shortcut icon" href="/img/logo.png" type="image/x-icon" />

<title>Rushy - {{ $page ?? 'Erreur' }}</title>
<meta name="description" content="Serveur Minecraft Rushy" />
<meta name="keywords" content="rushy rush rushland rushtheflag rtf rushzone rushbox pvpbox serveur minecraftpremium 1.8 1.9 1.10 1.11 1.12 1.13" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Google API font family -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,800,300,300italic,400italic,600,600italic,700italic,700,800italic" rel="stylesheet" />
<link href="https://fonts.googleapis.com/css?family=Nunito:400,700,800,900" rel="stylesheet">

<!-- FontAwesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

<!-- Bootstrap 4 & Laravel -->
<link href="/css/app.css" rel="stylesheet">
<script src="/js/app.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="/css/style.css"  type="text/css">
<link rel="stylesheet" href="/css/navbar.css" type="text/css">
<link rel="stylesheet" href="/css/footer.css" type="text/css">
<link rel="stylesheet" href="/css/@if(null != Request::route()){{Request::route()->getName()}}@endif.css" type="text/css">

<!-- JS -->
<script src="/js/particles.js" ></script>
<script type="text/javascript">
  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
</script>
<!-- Hotjar Tracking Code for https://rushy.fr -->
<script>
  (function(h,o,t,j,a,r){
      h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
      h._hjSettings={hjid:1248880,hjsv:6};
      a=o.getElementsByTagName('head')[0];
      r=o.createElement('script');r.async=1;
      r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
      a.appendChild(r);
  })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
