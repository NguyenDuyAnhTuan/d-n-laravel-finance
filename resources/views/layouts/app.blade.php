<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Quản lý tài chính')</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/sumaryStyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chitieu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/Settings.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/thunhap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/model.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/icon/icons8-money-bag-50.png') }}" />

    <!-- font add -->
    <link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <!-- header -->
    <header>
        <img class="header-icon" src="{{ asset('assets/icon/icons8-money-bag-50.png') }}" alt="icon" style="width: 40px" />
        <p class="header-title">JFINs - Quản lý tài chính</p>
    </header>

    <!-- main -->
    <main>
        @include('layouts.sidebar')
        
        @yield('content')
    </main>
    
    <!-- footer -->
    <footer>
        <p>Quản lý chi tiêu 6 hũ 2025 - Phát triển bởi nhóm 99</p>
    </footer>
    
    @yield('modals')

    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/modal.js') }}"></script>
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script src="{{ asset('assets/js/expense.js') }}"></script>
    <script src="{{ asset('assets/js/income.js') }}"></script>

    @stack('scripts')
</body>
</html>