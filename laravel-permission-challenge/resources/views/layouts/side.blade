<aside class="w-64 h-screen bg-white shadow-md">
    <nav class="mt-10">
        <ul>
            {{-- Permissions Link --}}
            @can('view permissions')
                <li class="mb-2">
                    <a href="{{ route('permissions.index') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-300 text-gray-700 {{ request()->routeIs('permissions.*') ? 'bg-gray-300' : '' }}">
                        Permissions
                    </a>
                </li>
            @endcan

            {{-- Roles Link --}}
            @can('view roles')
                <li class="mb-2">
                    <a href="{{ route('roles.index') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-300 text-gray-700 {{ request()->routeIs('roles.*') ? 'bg-gray-300' : '' }}">
                        Roles
                    </a>
                </li>
            @endcan

            {{-- Articles Link --}}
            @can('view articles')
                <li class="mb-2">
                    <a href="{{ route('articles.index') }}"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-300 text-gray-700 {{ request()->routeIs('articles.*') ? 'bg-gray-300' : '' }}">
                        Articles
                    </a>
                </li>
            @endcan
        </ul>
    </nav>
</aside>
{{-- resources/views/layouts/partials/sidebar.blade.php --}}
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div class="search-box px-3 py-2" id="sidebar-search-box">
            <div class="position-relative">
                <input type="text" class="form-control" id="menu-search" placeholder="Search menu..." autocomplete="off">
                <i class="bx bx-search-alt search-icon"></i>
            </div>
        </div>

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                @foreach ($menuItems as $item)
                    @php
                        $hasSubMenu = isset($item['sub_menu']) && !empty($item['sub_menu']);
                        $isActive = false;

                        if ($hasSubMenu) {
                            foreach ($item['sub_menu'] as $subItem) {
                                if (isset($subItem['route']) && request()->routeIs($subItem['route'])) {
                                    $isActive = true;
                                    break;
                                }
                                if (isset($subItem['sub_menu'])) {
                                    foreach ($subItem['sub_menu'] as $subSubItem) {
                                        if (request()->routeIs($subSubItem['route'] ?? '')) {
                                            $isActive = true;
                                            break 2;
                                        }
                                    }
                                }
                                if (isset($subItem['active_on_routes'])) {
                                    foreach ($subItem['active_on_routes'] as $pattern) {
                                        if (request()->routeIs($pattern)) {
                                            $isActive = true;
                                            break 2;
                                        }
                                    }
                                }
                            }
                        } elseif (isset($item['route'])) {
                            $isActive = request()->routeIs($item['route']);
                        }

                        if (isset($item['active_on_routes'])) {
                            foreach ($item['active_on_routes'] as $pattern) {
                                if (request()->routeIs($pattern)) {
                                    $isActive = true;
                                    break;
                                }
                            }
                        }

                        $menuClass = $isActive ? 'mm-active' : '';
                        $expanded = $isActive ? 'true' : 'false';

                        $canViewMenuItem = !isset($item['permission']) || auth()->user()?->canAny($item['permission']);
                    @endphp

                    @if ($canViewMenuItem)
                        <li class="{{ $menuClass }}">
                            <a href="{{ $hasSubMenu ? 'javascript:void(0);' : (isset($item['route']) ? route($item['route']) : '#') }}"
                               class="{{ $hasSubMenu ? 'has-arrow' : '' }} waves-effect">
                                <i class="{{ $item['icon'] }}"></i>
                                <span>@lang($item['name'])</span>
                            </a>

                            @if ($hasSubMenu)
                                <ul class="sub-menu" aria-expanded="{{ $expanded }}">
                                    @foreach ($item['sub_menu'] as $subItem)
                                        @php
                                            $hasSubSub = isset($subItem['sub_menu']);
                                            $subIsActive = request()->routeIs($subItem['route'] ?? '');
                                            if (isset($subItem['active_on_routes'])) {
                                                foreach ($subItem['active_on_routes'] as $pattern) {
                                                    if (request()->routeIs($pattern)) {
                                                        $subIsActive = true;
                                                        break;
                                                    }
                                                }
                                            }
                                            $subMenuClass = $subIsActive ? 'mm-active' : '';
                                            $canViewSub = !isset($subItem['permission']) || auth()->user()?->canAny($subItem['permission']);
                                        @endphp

                                        @if ($canViewSub)
                                            <li class="{{ $subMenuClass }}">
                                                <a href="{{ $hasSubSub ? 'javascript:void(0);' : (isset($subItem['route']) ? route($subItem['route']) : '#') }}"
                                                   class="{{ $hasSubSub ? 'has-arrow' : '' }} waves-effect">
                                                    <i class="{{ $subItem['icon'] }}"></i>
                                                    <span>@lang($subItem['name'])</span>
                                                </a>

                                                @if ($hasSubSub)
                                                    <ul class="sub-menu" aria-expanded="false">
                                                        @foreach ($subItem['sub_menu'] as $subSub)
                                                            @php
                                                                $active = request()->routeIs($subSub['route'] ?? '');
                                                                if (isset($subSub['active_on_routes'])) {
                                                                    foreach ($subSub['active_on_routes'] as $pattern) {
                                                                        if (request()->routeIs($pattern)) {
                                                                            $active = true;
                                                                            break;
                                                                        }
                                                                    }
                                                                }
                                                                $canViewSubSub = !isset($subSub['permission']) || auth()->user()?->canAny($subSub['permission']);
                                                            @endphp
                                                            @if ($canViewSubSub)
                                                                <li class="{{ $active ? 'mm-active' : '' }}">
                                                                    <a href="{{ route($subSub['route']) }}">
                                                                        <i class="{{ $subSub['icon'] }}"></i>
                                                                        <span>@lang($subSub['name'])</span>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
