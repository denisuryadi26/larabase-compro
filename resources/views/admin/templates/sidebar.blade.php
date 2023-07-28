@php $activeMenu = $menu['breadcrumbs']; @endphp
<!-- BEGIN: Main Menu-->

<ul class="menu">
    @foreach($menu['parentMenu'] as $item => $value)

    @if($value->is_showed)




    @if($item == 1 )
    <!-- <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Apps &amp; Pages</span>
    </li> -->
    @endif

    @foreach($value->access as $val)
    @if ($val->id == \Illuminate\Support\Facades\Auth::user()->group_id)

    @if($val->pivot->is_viewable == true)

    @if($value->childs->isEmpty())
    <!-- <li class="menu-item {{($value->name == $activeMenu->name ? 'active' : '')}}">
        <a href="{{route("$value->route_name")}}" class="menu-link">
            <i class="menu-icon tf-icons ti {{$value->icon}}"></i>
            <div data-i18n="{{$value->name}}">{{$value->name}}</div>
        </a>
    </li> -->
    <li class="menu-title">Navigation</li>
    <li class="menu-item {{($value->name == $activeMenu->name ? 'menuitem-active' : '')}}">
        <a href="{{route("$value->route_name")}}" class="menu-link {{($value->name == $activeMenu->name ? 'active' : '')}}">
            <span class="menu-icon"><i data-feather="{{$value->icon}}"></i></span>
            <span class="menu-text"> {{$value->name}} </span>
        </a>
    </li>

    <li class="menu-title">Apps</li>

    @else
    <li class="menu-item {{($activeMenu->parent ? $activeMenu->parent->name == $value->name ? 'menuitem-active' : '' : '')}}">
        <a href="#{{$value->name}}" data-bs-toggle="collapse" class="menu-link">
            <span class="menu-icon"><i data-feather="{{$value->icon}}"></i></span>
            <span class="menu-text"> {{$value->name}} </span>
            <span class="menu-arrow"></span>
        </a>
        <div class="collapse {{($activeMenu->parent ? $activeMenu->parent->name == $value->name ? 'show' : '' : '')}}" id="{{$value->name}}">
            <ul class="sub-menu">
                @foreach($value->childs as $key => $sub)
                @foreach($sub->access as $key => $subaccess)
                @if($subaccess->count() > 0)
                @if($subaccess->id == \Illuminate\Support\Facades\Auth::user()->group_id && $subaccess->pivot->is_viewable == true)
                <!-- <li class="menu-item {{($sub->name == $activeMenu->name ? 'active' : '')}}">
                    <a class="menu-link" href="{{route("$sub->route_name")}}">
                        <div data-i18n="{{$sub->name}}">{{$sub->name}}</div>
                    </a>
                </li> -->
                <li class="menu-item {{($sub->name == $activeMenu->name ? 'menuitem-active' : '')}}">
                    <a href="{{route("$sub->route_name")}}" class="menu-link {{($sub->name == $activeMenu->name ? 'active' : '')}}">
                        <span class="menu-text">{{$sub->name}}</span>
                    </a>
                </li>

                @endif
                @endif
                @endforeach
                @endforeach
            </ul>
        </div>
    </li>
    @endif
    @endif
    @endif
    @endforeach
    @endif
    @endforeach

</ul>
<!-- <div class="app-brand demo">
    <a href="index.html" class="app-brand-link">
        <span class="app-brand-logo demo">
            <svg width="32" height="22" viewBox="0 0 32 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z" fill="#7367F0" />
                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd" d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z" fill="#7367F0" />
            </svg>
        </span>
        <span class="app-brand-text demo menu-text fw-bold">Vuexy</span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
        <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
    </a>
</div> -->
<!-- <ul class="menu-inner py-1">
    @foreach($menu['parentMenu'] as $item => $value)

    @if($value->is_showed)




    @if($item == 1 )
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Apps &amp; Pages</span>
    </li>
    @endif

    @foreach($value->access as $val)
    @if ($val->id == \Illuminate\Support\Facades\Auth::user()->group_id)

    @if($val->pivot->is_viewable == true)

    @if($value->childs->isEmpty())
    <li class="menu-item {{($value->name == $activeMenu->name ? 'active' : '')}}">
        <a href="{{route("$value->route_name")}}" class="menu-link">
            <i class="menu-icon tf-icons ti {{$value->icon}}"></i>
            <div data-i18n="{{$value->name}}">{{$value->name}}</div>
        </a>
    </li>

    @else
    <li class="menu-item {{($activeMenu->parent ? $activeMenu->parent->name == $value->name ? 'active open ' : '' : '')}}">
        <a href="#" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons ti {{$value->icon}}"></i>
            <div data-i18n="{{$value->name}}">{{$value->name}}</div>
        </a>
        <ul class="menu-sub">
            @foreach($value->childs as $key => $sub)
            @foreach($sub->access as $key => $subaccess)
            @if($subaccess->count() > 0)
            @if($subaccess->id == \Illuminate\Support\Facades\Auth::user()->group_id && $subaccess->pivot->is_viewable == true)
            <li class="menu-item {{($sub->name == $activeMenu->name ? 'active' : '')}}">
                <a class="menu-link" href="{{route("$sub->route_name")}}">
                    <div data-i18n="{{$sub->name}}">{{$sub->name}}</div>
                </a>
            </li>

            @endif
            @endif
            @endforeach
            @endforeach
        </ul>

    </li>
    @endif
    @endif
    @endif
    @endforeach
    @endif
    @endforeach
</ul> -->