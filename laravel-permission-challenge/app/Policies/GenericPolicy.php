<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GenericPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models (e.g., list of articles).
     * This method is called by `viewAny` in `authorizeResource`.
     */
    public function viewAny(?User $user, $model) // Made $user nullable
    {
        // If no user is logged in, they cannot view the list of articles.
        if (!$user) {
            return false;
        }

        $permission = 'view ' . Str::kebab(Str::plural(class_basename($model))); // e.g., 'view articles'
        Log::info("Checking permission: " . $permission);
        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can view a specific model.
     * This method is called by `view` in `authorizeResource`.
     */
    public function view(?User $user, $model) // Made $user nullable
    {
        // If no user is logged in, they cannot view a specific article.
        if (!$user) {
            return false;
        }

        $permission = 'view ' . Str::kebab(class_basename($model)); // e.g., 'view article'
        Log::info("Checking permission: " . $permission);
        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can create models.
     * This method is called by `create` and `store` in `authorizeResource`.
     */
    public function create(?User $user, $model) // Already nullable, ensuring consistency
    {
        if (!$user) {
            return false;
        }
        $permission = 'create ' . Str::kebab(class_basename($model)); // e.g., 'create article'
        Log::info("Checking permission: " . $permission);
        return $user->hasPermissionTo($permission);
    }

    /**
     * Determine whether the user can update the model.
     * This method is called by `update` and `edit` in `authorizeResource`.
     */
    public function update(?User $user, $model) // Made $user nullable
    {
        if (!$user) {
            return false;
        }
        $permission = 'update ' . Str::kebab(class_basename($model)); // e.g., 'update article'
        Log::info("Checking permission: " . $permission);
        // Added logic to check if the user owns the article or has an 'admin' role
        return $user->hasPermissionTo($permission) && ($user->id === $model->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine whether the user can delete the model.
     * This method is called by `destroy` in `authorizeResource`.
     */
    public function delete(?User $user, $model) // Made $user nullable
    {
        if (!$user) {
            return false;
        }
        $permission = 'delete ' . Str::kebab(class_basename($model)); // e.g., 'delete article'
        Log::info("Checking permission: " . $permission);
        // Added logic to check if the user owns the article or has an 'admin' role
        return $user->hasPermissionTo($permission) && ($user->id === $model->user_id || $user->hasRole('admin'));
    }

    /**
     * Determine whether the user can approve the model.
     * This is a custom action not covered by `authorizeResource` by default.
     */
    public function approve(?User $user, $model) // Made $user nullable
    {
        if (!$user) {
            return false;
        }
        $permission = 'approve ' . Str::kebab(class_basename($model)); // e.g., 'approve article'
        Log::info("Checking permission: " . $permission);
        return $user->hasPermissionTo($permission);
    }
}
