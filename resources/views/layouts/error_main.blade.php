<!DOCTYPE html>

<html class="master-layout" lang="{{ app()->getLocale() }}">
@include('layouts.master_partials.header')
@if(Auth::check())
    @include('layouts.master_partials.sidebar')
@endif
@yield('content')
@include('layouts.master_partials.footer')
@stack('header-css')
</html>