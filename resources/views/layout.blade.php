<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=100%, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <title>Document</title>
</head>

<body>
    <div class="container-fluid p-0 m-0">
        <div class="row-fluid no-gutters">
            <div class="col-md-12">
                <div class="topbar">
                </div>
            </div>
        </div>
    </div>
    <div class="header">
        <div class="container h-100">
            <div class="row">
                <div class="col-md-12">
                    <div class="site-title">{{ $name ?? "Home" }}</div>
                    @yield('action')
                </div>
            </div>
        </div>
    </div>
    @yield('form')    
    @yield('status')
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script>
    ;(function(){
        $(document).ready(function(){
            
        });
      });
</script>
@yield('script')
</html>