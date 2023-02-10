
    
<!DOCTYPE html>
<html lang="{{ $selected_language->code }}">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="author" content="criativatek">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />

        <title>{!! json_decode($settings->title, true)[$selected_language->code] !!} | @yield('title')</title>

        <meta name="description" content="/{{ $selected_language->code }}/">
        <!-- favicon icon -->
        <meta name="application-name" content="{!! json_decode($settings->title, true)[$selected_language->code] !!}">
        <meta name="msapplication-TileColor" content="{{ $settings->colors }}">
        <meta name="theme-color" content="{{ $settings->colors }}">
        <link rel="shortcut icon" href="{{$settings->favicon}}">

        <!--<link rel="apple-touch-icon" href="/public/static/images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/public/static/images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/public/static/images/apple-touch-icon-114x114.png">-->
        <!-- style sheets and font icons  -->
        <!--<link rel="apple-touch-icon" href="images/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">-->
        <!-- style sheets and font icons  -->
        <link rel="stylesheet" type="text/css" href="/public/static/css/font-icons.min.css">
        <link rel="stylesheet" type="text/css" href="/public/static/css/theme-vendors.min.css">
        <link rel="stylesheet" type="text/css" href="/public/static/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/public/static/css/responsive.css" />
        <link rel="stylesheet" type="text/css" href="/public/static/css/cdl.css" />

    </head>
    
    <body data-mobile-nav-style="classic" id="body_editor">
            <div>
                @yield('content')    
            </div>    
    </body>
</html>