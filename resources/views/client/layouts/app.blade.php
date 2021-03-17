<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('client.layouts.head')

<body class="nav-sm">
  @include('client.layouts.header')
  @yield('content')
  @include('client.layouts.footer')
  @include('client.layouts.foot')

  <body>
    <html>