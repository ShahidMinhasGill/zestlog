<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>Zestlog</title>
    <link rel="icon" type="image/png" href="{{asset('assets/images/Chela One 2-1 Final.png')}}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- select 2 css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />

  <!-- custom css -->
  <link rel="stylesheet" href="{{asset('css/app.css?id=').version()}}">
  <link rel="stylesheet" href="{{asset('css/custom.css?id=').version()}}">
</head>
<script type="text/javascript" src="/js/jquery.slim.min.js"></script>
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
{!! Html::script('js/common.js') !!}
<style>
  .no-record-found {
    color: red;
    font-size: large;
  }
</style>
<body class="nav-sm">
<div id="preloader"></div>
  @include('layouts.header')
  @yield('content')
  @include('layouts.footer')

<body>

<html>
