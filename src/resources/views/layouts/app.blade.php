<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    <title>timetrack</title>
</head>
<body>
  <div class="container">
    <header class="header">
      <div class="header_inner">
        <div class="header_inner-left">
          <h2 class="site-title">Atte</h2>
        </div>
        @yield('header_inner-right')
    </header>

    <main>
    @yield('content')
    </main>

    <footer class="footer">
      <p class="company-name">Atte,inc.</p>
    </footer>
  </div>  
</body>
</html>