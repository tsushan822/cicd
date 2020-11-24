<!DOCTYPE html>

<html class="master-layout" lang="{{ app()->getLocale() }}">
@include('layouts.master_partials.header')
    @include('layouts.master_partials.content')
@include('layouts.master_partials.footer')
@stack('header-css')
</html>