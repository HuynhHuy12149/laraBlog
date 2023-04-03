
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('pageTitle')</title>
    <!-- CSS files -->
    {{-- <base href="/"> --}}
    <link rel="shortcut icon" href="{{ \App\Models\Setting::find(1)->blog_favicon }}" type="image/x-icon">
    <link href="/back/dist/css/tabler.min.css?1674944402" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-flags.min.css?1674944402" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-payments.min.css?1674944402" rel="stylesheet"/>
    <link href="/back/dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet"/>
    <link rel="stylesheet" href="/back/dist/libs/ijabo/ijabo.min.css">
    <link rel="stylesheet" href="/back/dist/libs/ijaloCropImg/ijaboCropTool.min.css">
    @stack('stylesheets')
    <link href="/back/dist/css/demo.min.css?1674944402" rel="stylesheet"/>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }

      .swal2-popup{
        font-size: .85rem;
      }
    </style>
  </head>
  <body >
    <script src="./back/dist/js/demo-theme.min.js?1674944402"></script>
    <div class="page">
      <!-- Navbar -->
     <!-- header để bên header.blade.php -->
     @include('back.layouts.inc.header')
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <!-- Page title -->
            @yield('pageHeader')

          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container-xl">
            @yield('content')
          </div>
        </div>
        <!-- footer trong footer.blade.php-->
        @include('back.layouts.inc.footer')
      </div>
    </div>
    
    <!-- Libs JS -->
    <script src="/back/dist/libs/jquery/jquery-3.6.0.min.js"></script>
    <script src="/back/dist/libs/ijabo/ijabo.min.js"></script>
    <script src="/back/dist/libs/ijaloCropImg/ijaboCropTool.min.js"></script>
    <script src="/back/dist/libs/ijaboViewer/jquery.ijaboViewer.min.js"></script>
    <script src="/back/dist/libs/apexcharts/dist/apexcharts.min.js?1674944402" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1674944402" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/maps/world.js?1674944402" defer></script>
    <script src="/back/dist/libs/jsvectormap/dist/maps/world-merc.js?1674944402" defer></script>
    <!-- Tabler Core -->
    <script src="/back/dist/js/tabler.min.js?1674944402" defer></script>
    @stack('scripts')
    @livewireScripts
    <script>
      window.addEventListener('showToastr',function(event){
        toastr.remove();
        if(event.detail.type==='info'){
          toastr.info(event.detail.message);
        }else if(event.detail.type==='success'){
          toastr.success(event.detail.message);
        }else if(event.detail.type==='error'){
          toastr.error(event.detail.message);
        }else if(event.detail.type==='warning'){
          toastr.warning(event.detail.message);
        }else{
          return false;
        }
      });
    </script>
    <script src="/back/dist/js/demo.min.js?1674944402" defer></script>
    
  </body>
</html>