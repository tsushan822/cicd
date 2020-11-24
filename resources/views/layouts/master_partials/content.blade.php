<div class="container-fluid text-center pl-0 pr-0 ml-0 mr-0" id="main_container">

    @if(Auth::check())
        @include('layouts.master_partials.sidebar')
    @endif

    <div class="content_ui mt-5 pt-4">
        @if(checkNonDeveloper() && auth()->user()->teams[0]->trial_ends_at)
            @if(checkNonDeveloper() && !auth()->user()->teams[0]->trial_ends_at->isPast())
                <div class="alert  text-left alert-warning trialbar mb-2 ">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    {{trans('master.Your free trial will expire on ')}}
                    <strong>{{auth()->user()->teams[0]->trial_ends_at->format('Y - M - d')}}</strong>.
                    @if(auth()->user()->teams[0]->owner_id == auth()->user()->id)
                        <a href="/settings/teams/{{auth()->user()->teams[0]->id.'#/subscription'}}">
                            {{trans('master.Customize Plan!')}}</a>
                    @endif
                </div>
            @endif
        @endif
        @include('flash::message')
        <?php session() -> forget('flash_notification') ?>
        <p class="view_as d-none">@lang('master.As of')
            {!! Carbon\Carbon::now()->formatLocalized('%d %B %Y');!!}
            @lang('master.at')
            {!! Carbon\Carbon::now('Europe/Helsinki')->format('H:i') !!} (UTC+2) •
            @if(Auth::check())
                @lang('master.Viewing as') {!! Auth::user()->name!!}
            @endif</p>
        @include('errors.form_errors')
        @yield('content')
    </div>
</div>


