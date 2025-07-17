<aside class="w-64 h-screen bg-white dark:bg-gray-800 shadow-md">
    <nav class="mt-10">
        <ul>
           
            <li class="mb-2">
                <a href="{{ route('permissions.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('permissions.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                    Permissions
                </a>
            </li>
            <li class="mb-2">
                <a href="{{ route('roles.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 {{ request()->routeIs('roles.*') ? 'bg-gray-200 dark:bg-gray-700' : '' }}">
                    Roles
                </a>
            </li>
        </ul>
    </nav>
</aside>