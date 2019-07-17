<script src="/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/toastr.css">


<script>
  toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
  }	
  
  @if(Session::has('success'))
    toastr.success("{{ Session::get('success') }}");
  @endif
  

  @if(Session::has('info'))
    toastr.info("{{ Session::get('info') }}");
  @endif


  @if(Session::has('warning'))
    toastr.warning("{{ Session::get('warning') }}");
  @endif


  @if(Session::has('error'))
    toastr.error("{{ Session::get('error') }}");
  @endif
  
  @if ($errors->any())
    @foreach ($errors->all() as $error)
        toastr.error("{{ $error }}");
    @endforeach
  @endif
  
</script>