<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="img/icon.ico" type="image/x-icon">
  <script src="https://kit.fontawesome.com/525a9b21ee.js" crossorigin="anonymous"></script>
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="css/style.css">
  @vite('resources/css/app.css')
</head>
<body class="m-0 font-sans text-base antialiased bg-gray-50 text-slate-500">
  <div class="absolute w-full bg-blue-500 min-h-75"></div>
  @include('admin.layouts.sidebar')
  <main class="ease-soft-in-out xl:ml-68.5 pt-20 relative h-full max-h-screen rounded-xl transition-all duration-200">
    @include('admin.layouts.navbar')
    <section class="w-full px-4 py-5 mx-auto">
      @yield('container')
    </section>
    @include('admin.layouts.alert')
  </main>

  <script src="{{ asset('js/search.js') }}"></script>
  <script src="{{ asset('js/crud.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>
  @stack('scripts')
</body>
</html>