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
