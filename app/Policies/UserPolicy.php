<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Auth\Access\Response;
use App\Models\Model; // Thêm lớp Model nếu bạn cần
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update($authUser, User $user)
    {
        if ($authUser instanceof GenericUser) {
            $authUser = User::findOrFail($authUser->getAuthIdentifier());
        }

        return $authUser->role === 'admin' || $authUser->id === $user->id;
    }

    public function delete(User $authUser, User $user)
    {
        return $authUser->role === 'admin';
    }
}
