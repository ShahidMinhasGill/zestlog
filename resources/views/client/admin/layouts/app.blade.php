<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@include('client.admin.layouts.head')

<body class="nav-sm">
  @include('client.admin.layouts.header')
  @yield('content')
  @include('client.admin.layouts.footer')
  @include('client.admin.layouts.foot')

  <body>
    <html>