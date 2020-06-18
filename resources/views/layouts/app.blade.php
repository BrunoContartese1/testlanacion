<!DOCTYPE html>
<html>
    @include('layouts.head')
    <body>
        @include('layouts.header')
        <div class="d-flex align-items-stretch">
            @include('layouts.menu')
            @yield('css')
        <div class="page-content">
            <div class="page-header">
                <div class="container-fluid">
                    <h2 class="h5 no-margin-bottom">@yield('pageName')</h2>
                </div>
            </div>
            <section class="no-padding-top no-padding-bottom">
                <div id="app">

                    @yield('content')
                </div>
            </section>
            @include('layouts.footer')
            </div>
        </div>
        <!-- JavaScript files-->
        <script src="/js/app.js"></script>
        <script src="/js/all.js"></script>
        @yield('scripts')
    </body>
</html>
