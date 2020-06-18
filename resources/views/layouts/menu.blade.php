<!-- Sidebar Navigation-->
<nav id="sidebar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
      <div class="avatar"><img src="{{ Auth::user()->profile_image_url ?? '/assets/images/user-img.png' }}" alt="..." class="img-fluid rounded-circle"></div>
      <div class="title">
        <h1 class="h5">{{ Auth::user()->name ?? 'Usuario' }}</h1>
      </div>
    </div>

    <!-- Sidebar Navidation Menus-->
    {{-- <span class="heading">Main</span> --}}

    <ul class="list-unstyled">

        @include('layouts.menuPartials.simpleMenu', [
            'permission' => 'dashboard.view',
            'request' => 'home*',
            'icon' => 'icon-home',
            'url' => '/',
            'name' => "Principal"
        ])

        @include('layouts.menuPartials.administrationMenu')
</nav>
  <!-- Sidebar Navigation end-->
