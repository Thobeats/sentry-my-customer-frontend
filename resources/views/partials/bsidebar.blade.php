<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">
    
    <div class="sidebar-content">
        <!--- Sidemenu -->
        <div id="sidebar-menu" class="slimscroll-menu">
            <ul class="metismenu" id="menu-bar">
                <li class="menu-title">Navigation</li>

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'super_admin')
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.super_admin')
                @endif

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_admin')
                    {{--super admin protected routes here--}}
                    @include('partials.menus_items.store_admin')
                @endif

                @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_assistant')
                    {{-- super admin protected routes here --}}
                    @include('partials.menus_items.store_assistant')
                @endif

                {{-- @wealth removed changed password from here, its now inside settings page --}}
                {{-- <li>
                <a href="{{ route('change_password') }}">
                     <i class="uil  uil-cog"></i>
                        <span> Change Password </span>
                 </a>
                </li> --}}

            </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
