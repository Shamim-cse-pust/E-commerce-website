
<!DOCTYPE html>
<html lang="en" data-footer="true" data-override='{"attributes": {"placement": "vertical", "layout": "boxed" }, "storagePrefix": "ecommerce-platform"}'>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Laracom| @yield('title')</title>
    <meta name="description" content="Ecommerce Dashboard" />

    @include('backend.layout.inc.style')

  </head>

  <body>
    <div id="root">
      <div id="nav" class="nav-container d-flex">
        <div class="nav-content d-flex">
       @include('backend.layout.inc.logo')

       @include('backend.layout.inc.user-menu')

       @include('backend.layout.inc.menu')

          <!-- Mobile Buttons Start -->
          <div class="mobile-buttons-container">
            <!-- Menu Button Start -->
            <a href="#" id="mobileMenuButton" class="menu-button">
              <i data-cs-icon="menu"></i>
            </a>
            <!-- Menu Button End -->
          </div>
          <!-- Mobile Buttons End -->
        </div>
        <div class="nav-shadow"></div>
      </div>

      <main>
        <div class="container mt-5">
          @yield('admin_contain')
        </div>
      </main>







    {{-- @include('backend.layout.inc.search-module') --}}
    @include('backend.layout.inc.footer')
</div>

    @include('backend.layout.inc.script')
  </body>
</html>
