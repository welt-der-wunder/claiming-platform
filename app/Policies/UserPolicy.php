<?php

namespace App\Policies;

use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->role === UserRoles::$ROLE_ADMIN;
    }

    public function me(User $user)
    {
        return true;
    }

    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->role === UserRoles::$ROLE_ADMIN;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->role === UserRoles::$ROLE_ADMIN;
    }

    public function delete(User $user, User $model)
    {
        return false;
    }

    public function restore(User $user, User $model)
    {
        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::notAllowedResponse());
    }

    public function forceDelete(User $user, User $model)
    {
        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::notAllowedResponse());
    }

    public function adminOnly(User $user)
    {
        return $user->isAdmin();
    }

    public function superAdmin(User $user)
    {
        return $user->isSuperAdmin() ? true : Response::deny(AuthorizationResponses::notAllowedResponse());
    }
}
