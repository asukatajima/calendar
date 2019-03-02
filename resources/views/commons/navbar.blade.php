<header class="mb-4">
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary"> 
        <a class="navbar-brand" href="/"><div style="font-size: 38px;">Schedule Calendar</div></a>
         
       
        <div class="collapse navbar-collapse" id="nav-bar">
            <ul class="navbar-nav mr-auto"></ul>
            <ul class="navbar-nav">
                @if (Auth::check())
                    <li class="nav-item active dropdown">
                        
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->name }}</a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            
                            <li class="dropdown-divider"></li>
                            <li class="dropdown-item">{!! link_to_route('logout.get', 'ログアウト') !!}</li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item active">{!! link_to_route('signup.get', '新規登録', [], ['class' => 'nav-link']) !!}</li>
                    <li class="nav-item active">{!! link_to_route('login', 'ログイン', [], ['class' => 'nav-link']) !!}</li>
    
                @endif
            </ul>
        </div>
    </nav>
</header>