<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear">
                            <span class="block m-t-xs">
                                <strong class="font-bold">{{ Auth::user()->getPerson->name }}</strong> <b class="caret"></b>
                            </span> 
                        </span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{ route('user.edit', Auth::user()->id) }}">Perfil</a></li>
                        <li><a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">Logout</a></li>
                        <form id="logout-form" action="{{ url('/painel/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </ul>
                </div>
                <div class="logo-element">
                    V2+
                </div>
            </li>
            <li class="{{ (Route::currentRouteName() == 'main') ? 'active' : '' }}">
                <a href="{{ url('/painel') }}">
                    <i class="fa fa-home"></i> 
                    <span class="nav-label">Home</span>
                </a>
            </li>
<?php
            $menusGrand = Auth::user()
                                ->getPerson
                                ->getRole
                                ->getPermission()
                                ->whereHas('getMenu', function($query){
                                    $query->whereRaw('ISNULL(menu_id)')->where('show', '1');
            })
            ->get();
?>
            @foreach($menusGrand as $grand)

                <li class="{{ isActiveRoute($grand->menu_id) }}">

                    @if($grand->getMenu->getChildren()->where('show', '1')->count() > 0)
                        <a href="#">
                            <i class="fa {{ $grand->getMenu->icon }}"></i> 
                            <span class="nav-label">{{ $grand->getMenu->menu }}</span>
                            <span class="fa arrow"></span>
                        </a>
                        <ul class="nav nav-second-level collapse">               
<?php
                            $menusFather = Auth::user()
                                    ->getPerson
                                    ->getRole
                                    ->getPermission()
                                    ->whereHas('getMenu', function($query) use($grand){
                                        $query->where('menu_id', $grand->menu_id)->where('show', '1');
                                    })
                                    ->get();
?>
                            @foreach($menusFather as $father)                           
                                <li class="{{ isActiveRoute($father->menu_id) }}">
                                    @if($father->getMenu->getChildren()->where('show', '1')->count() > 0)
                                        <a href="#">
                                            <i class="fa {{ $father->getMenu->icon }}"></i> 
                                            <span class="nav-label">{{ $father->getMenu->menu }}</span>
                                            <span class="fa arrow"></span>
                                        </a>
                                        <ul class="nav nav-third-level collapse">
<?php
                                            $sonMenu = Auth::user()
                                                        ->getPerson
                                                        ->getRole
                                                        ->getPermission()
                                                        ->whereHas('getMenu', function($query) use($father){
                                                            $query->where('menu_id', $father->menu_id)->where('show', '1');
                                                        })
                                                        ->get();
?>                                        
                                            @foreach($sonMenu as $son)
                                                <li class="{{ isActiveRoute($son->menu_id) }}">
                                                     <a href="{{ route($son->getMenu->route) }}">
                                                        <i class="fa {{ $son->getMenu->icon }}"></i> 
                                                        <span class="nav-label">{{ $son->getMenu->menu }}</span>
                                                    </a>
                                                </li>                                                
                                            @endforeach
                                        </ul>
                                    @else
                                        <a href="{{ route($father->getMenu->route) }}">
                                            <i class="fa {{ $father->getMenu->icon }}"></i> 
                                            <span class="nav-label">{{ $father->getMenu->menu }}</span>
                                        </a>
                                    @endif
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <a href="{{ route($grand->getMenu->route) }}">
                            <i class="fa {{ $grand->getMenu->icon }}"></i> 
                            <span class="nav-label">{{ $grand->getMenu->menu }}</span>
                        </a>
                    @endif

                </li>
            @endforeach
        </ul>



    </div>
</nav>
