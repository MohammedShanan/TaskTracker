<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title class="text-capitalize">@yield('title')</title>
</head>
<body>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
    <h1 class="text-center mt-5">Welcome to Tasktraker</h1>
    <div class="container-fluid full-height d-flex justify-content-center align-items-center">
        <form method="POST" action="/@yield('title')" class="d-flex flex-column w-75 mt-5 justify-content-center align-items-center">
            @csrf
        <h1>@yield('name')</h1>
        @yield("content")
        <div class="d-grid gap-2 col-3 mx-auto mt-3">
            <div class="w-100">@yield("question")?<a href="/@yield('link')" class="link-underline-light" type="button">@yield('link name')</a></div>
            <button class="btn btn-primary" type="submit">@yield('name')</button>
        </div>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>