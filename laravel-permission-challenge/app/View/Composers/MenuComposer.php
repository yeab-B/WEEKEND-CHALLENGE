<?php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class MenuComposer
{
    public function compose(View $view)
    {
        $menuItems = config('menu');
        $filteredMenu = $this->filterMenuItems($menuItems);
        $view->with('menuItems', $filteredMenu);
    }

    protected function filterMenuItems(array $menuItems)
    {
        $user = Auth::user();

        return array_filter($menuItems, function ($item) use ($user) {
            // Check parent permission
            if (isset($item['permission']) && $item['permission'] !== null) {
                if (is_array($item['permission'])) {
                    $hasPermission = false;
                    foreach ($item['permission'] as $permission) {
                        if ($user && method_exists($user, 'can') && $user->can($permission)) {
                            $hasPermission = true;
                            break;
                        }
                    }
                    if (!$hasPermission) {
                        return false;
                    }
                } else {
                    if ($user && method_exists($user, 'can') && !$user->can($item['permission'])) {
                        return false;
                    }
                }
            }

            // Recursively filter sub-menus
            if (isset($item['sub_menu']) && is_array($item['sub_menu'])) {
                $item['sub_menu'] = $this->filterMenuItems($item['sub_menu']);
                // If a parent item has no route but has sub_menu, it should be visible if any sub_menu item is visible
                if ($item['route'] === null && empty($item['sub_menu'])) {
                    return false;
                }
            }

            // If it has a route, check if the user has permission to view that route, or if there's no permission required.
            if (isset($item['route']) && $item['route'] !== null) {
                if (isset($item['permission']) && $item['permission'] !== null) {
                    if (is_array($item['permission'])) {
                        $hasPermission = false;
                        foreach ($item['permission'] as $permission) {
                            if ($user && method_exists($user, 'can') && $user->can($permission)) {
                                $hasPermission = true;
                                break;
                            }
                        }
                        if (!$hasPermission) {
                            return false;
                        }
                    }
                    else if ($user && method_exists($user, 'can') && !$user->can($item['permission'])) {
                        return false;
                    }
                }
            }
            
            return true;
        });
    }
} 