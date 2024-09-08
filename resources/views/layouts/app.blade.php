<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <title>@yield('title')</title>
</head>
<body>
<header><nav class="navbar bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{route('boards.index')}}">TaskTracker</a>
    <form method="POST" class="d-flex" action="{{route('logout')}}">
        @csrf
      <button class="btn btn-outline-secondary" type="submit">logout</button>
    </form>
  </div>
</nav></header>

@yield('content')
@vite(['resources/js/app.js'])
@yield('js')
</body>
</html>