<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUMAR</title>
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    {{-- Vite: Tailwind v4 + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles') {{-- ← untuk Leaflet CSS --}}
</head>

<body>
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @stack('scripts') {{-- ← untuk Leaflet JS + logic --}}
</body>

</html>