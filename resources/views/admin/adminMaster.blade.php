
<!DOCTYPE html>
<html lang="en">
@include('layouts/header') 
<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-primary position-absolute w-100"></div>
  @include('layouts/sidenav')
  <main class="main-content position-relative border-radius-lg ">
    @include('layouts/navbar')
    @yield('content')
  </main>
  @include('layouts/appearence')
  @include('layouts/mainScripts')  
</body>
</html>