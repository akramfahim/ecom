
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Ecommerce</title>

  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
</head>
<body class="hold-transition sidebar-mini">
  <div class="wrapper" id="app">

    @if(Auth::check())
      <adminapp :user="{{ Auth::user() }}"></adminapp>
    @else
      <adminapp :user="false"></adminapp>
    @endif

  </div>
  <!-- REQUIRED SCRIPTS -->
  <script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>

