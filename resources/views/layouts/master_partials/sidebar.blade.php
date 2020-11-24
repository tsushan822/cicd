<div class="header_ui_background fixed-top">
    <div class="header_ui_area">
        <div class="top_header ">
            <div class="top_header_left">
                <a href="/main"><img src="/img/logo.svg" alt="" class="srcimg" style="width:80px"></a>
            </div>
            <div class="module_link_area d-flex align-items-center">
                <ul class="nav  md-pills ">
                    <li class="nav-item">
                        <a class="nav-link {{ ( strpos(Route::currentRouteName(), 'dashboard') !== false )  ? 'active' : '' }}"
                           href="/main" role="tab">{{trans('master.Dashboard')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ ( strpos(Route::currentRouteName(), 'leases') !== false || strpos(Route::currentRouteName(), 'archive') !==false) ? 'active' : '' }}"
                           href="/leases" role="tab">{{trans('master.Leases')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (strpos(Route::currentRouteName(), 'reportcard') !== false | strpos(Route::currentRouteName(),'reporting')!==false) ? 'active' : '' }}"
                           href="/reports-all" role="tab">{{trans('master.Reports')}}</a>
                    </li>
                    @if(app('reportLibraryAvailability'))
                        <li class="nav-item">
                            <a class="nav-link {{ (strpos(Route::currentRouteName(), 'report-library') !== false) ? 'active' : ''   }}"
                               href="/report-library/index" role="tab">{{trans('master.Library')}}</a>
                        </li>
                    @endif
                </ul>
            </div>
            <div class=" top_header_right d-flex align-items-center">
                <ul class="nav navbar-nav nav-flex-icons  ml-auto header_ui_ul">
                    <div id="notificationArea">
                        <notification
                                last_read_announcements_at="{{auth()->user()->last_read_announcements_at}}"></notification>
                        @stack('checkEnvironmentReadiness')
                    </div>
                    {{--@if (Auth::check()){!!'/freshdesk'.'?user='.Auth::user()->name.'&&email='.Auth::user()->email !!}--}}
                    {{-- https://zentreasuryservice.freshworks.com/login?redirect_uri=https://leaseaccounting.freshdesk.com/freshid/customer_authorize_callback&client_id=78368727158800390&slug=lease--}}
                    @if (Auth::check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle top_header_a waves-effect waves-light"
                               href="/jwtfreshdeskloginpage"
                               target="_blank">
                                <i class="fa fa-question-circle text-white"></i>
                            </a>

                        </li>
                    @endif
                    <li class="nav-item dropdown" id="dropdownSetting">
                        <a class="nav-link dropdown-toggle top_header_a" href="#" id="navbarDropdownMenuLink"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="false">
                            <i class="fa fa-cog text-white "></i>
                            <span class="d-none d-md-inline-block ml-1 mr-1">@lang('master.Settings')</span>
                        </a>

                        <div class="dropdown-menu fitContent dropdown-menu-right"
                             aria-labelledby="navbarDropdownMenuLink">
                            {{-- <a class="dropdown-item" href="{!! route('accounts.index') !!}">
                                 @lang('master.Bank Accounts')
                             </a>--}}

                            {{-- <div class="dropdown-divider"></div>--}}

                            <a class="dropdown-item" href="{!! route('counterparties.index') !!}">
                                @lang('master.Companies')
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{!! route('lease-types.index') !!}">@lang('master.Lease types')</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{!! route('portfolios.index') !!}">
                                @lang('master.Portfolios')
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{!! route('costcenters.index') !!}">
                                @lang('master.Cost centers')
                            </a>
                            @if(auth()->check() && auth()->user()->hasRole('admin'))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('fxrates.index') !!}">
                                    @lang('master.Fx Rates')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('currencies.index') !!}">
                                    @lang('master.Currencies')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('countries.index') !!}">
                                    @lang('master.Countries')
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('admin-settings.index') !!}">
                                    @lang('master.Admin Settings')
                                </a>
                            @endif
                        </div>
                    </li>
                    @if(auth()->check())
                        <li class="nav-item dropdown" id="dropdownUser">
                            <a class="nav-link top_header_a dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false">
                                <i class="fa fa-user text-white"></i>
                                <span class="d-none d-md-inline-block ml-1 mr-1">@lang('master.Users')</span>
                            </a>
                            <div class="dropdown-menu fitContent dropdown-menu-right"
                                 aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item " href="{!! route('users.edit', Auth::id()) !!}">
                                    <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                    @lang('master.User details')
                                </a>
                                @can('edit_role')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="{!! route('roles.index') !!}">
                                        <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        @lang('master.User roles')
                                    </a>
                                @endcan
                                @can('edit_user')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="{!! route('users.index') !!}">
                                        <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        @lang('master.Users')
                                    </a>
                                @endcan
                                @if(auth()->check() && in_array(auth()->user()->id, \App\Zen\System\Model\Team::get()->pluck('owner_id')->toArray()))
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="button"
                                       href="/settings/teams/{{auth()->user()->current_team_id}}#/subscription">
                                        <i class="fas mr-2 fa-file-invoice"></i>
                                        @lang('master.Subscription')

                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" role="button" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa mr-2 fa-power-off "></i>
                                    @lang('master.Logout')
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

        </div>


        <nav class="navbar  navbar-dark bg-dark d-none boxShadowRemoval navbar-la-mobile">
            <a href="/main" class="navbar-brand"><img src="/img/logo.svg" alt="" class="src" style="width:80px"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    {{-- <li class="nav-item active">
                         <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="#">Link</a>
                     </li>
                     <li class="nav-item dropdown">
                         <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             Dropdown
                         </a>
                         <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                             <a class="dropdown-item" href="#">Action</a>
                             <a class="dropdown-item" href="#">Another action</a>
                             <div class="dropdown-divider"></div>
                             <a class="dropdown-item" href="#">Something else here</a>
                         </div>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link disabled" href="#">Disabled</a>
                     </li>--}}
                    <li class="nav-item {{ ( strpos(Route::currentRouteName(), 'dashboard') !== false )  ? 'active' : '' }}">
                        <a class="nav-link " href="/main" role="tab">{{trans('master.Dashboard')}}</a>
                    </li>
                    <li class="nav-item {{ ( strpos(Route::currentRouteName(), 'leases') !== false || strpos(Route::currentRouteName(), 'archive') !==false) ? 'active' : '' }}">
                        <a class="nav-link " href="/leases" role="tab">{{trans('master.Register')}}</a>
                    </li>
                    {{-- <li class="nav-item">
                         <a class="nav-link {{ (strpos(Route::currentRouteName(), 'archive') !== false) ? 'active' : '' }}"  href="/leases/archive" role="tab">{{trans('master.Archive')}}</a>
                     </li>--}}
                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'reportcard') !== false | strpos(Route::currentRouteName(),'reporting')!==false) ? 'active' : '' }}">
                        <a class="nav-link " href="/reports-all" role="tab">{{trans('master.Reports')}}</a>
                    </li>
                    <li class="nav-item {{ (strpos(Route::currentRouteName(), 'report-library') !== false) ? 'active' : ''   }}">
                        <a class="nav-link " href="/report-library/index"
                           role="tab">{{trans('master.Automation')}}</a>
                    </li>
                    <div id="notificationArea">
                        <notification
                                last_read_announcements_at="{{auth()->user()->last_read_announcements_at}}"></notification>
                    </div>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @lang('master.Settings')
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <a class="dropdown-item" href="{!! route('costcenters.index') !!}">
                                @lang('master.Cost centers')
                            </a>


                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{!! route('counterparties.index') !!}">
                                @lang('master.Companies')
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{!! route('portfolios.index') !!}">
                                @lang('master.Portfolios')
                            </a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item"
                               href="{!! route('lease-types.index') !!}">@lang('master.Lease types')</a>


                            @if(auth()->check() && auth()->user()->hasRole('admin'))
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('admin-settings.index') !!}">
                                    @lang('master.Admin Settings')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('currencies.index') !!}">
                                    @lang('master.Currencies')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('countries.index') !!}">
                                    @lang('master.Countries')
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{!! route('fxrates.index') !!}">
                                    @lang('master.Foreign Exchange Rates')
                                </a>
                            @endif
                        </div>
                    </li>

                    @if(auth()->check())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @lang('master.Users')
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                                <a class="dropdown-item " href="{!! route('users.edit', Auth::id()) !!}">
                                    <i class="fas fa-user-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                                    @lang('master.User details')
                                </a>
                                @can('edit_role')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="{!! route('roles.index') !!}">
                                        <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                        @lang('master.User roles')
                                    </a>
                                @endcan
                                @can('edit_user')
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item " href="{!! route('users.index') !!}">
                                        <i class="fa fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        @lang('master.Users')
                                    </a>
                                @endcan
                                @if(auth()->check())
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" role="button"
                                       href="/settings/teams/{{auth()->user()->current_team_id}}#/subscription">
                                        <i class="fas mr-2 fa-file-invoice"></i>
                                        @lang('master.Subscription')

                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" role="button" href="{{ url('/logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa mr-2 fa-power-off "></i>
                                    @lang('master.Logout')

                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endif


                </ul>
            </div>
        </nav>
    </div>

</div>

