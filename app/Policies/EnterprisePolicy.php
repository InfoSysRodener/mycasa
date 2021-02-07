<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Enterprise;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnterprisePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any enterprises.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the enterprise.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enterprise  $enterprise
     * @return mixed
     */
    public function view(User $user, Enterprise $enterprise)
    {
        //
    }

    /**
     * Determine whether the user can create enterprises.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
        if($user->user_type === 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the enterprise.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enterprise  $enterprise
     * @return mixed
     */
    public function update(User $user, Enterprise $enterprise)
    {
        //
        if($user->user_type === 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the enterprise.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enterprise  $enterprise
     * @return mixed
     */
    public function delete(User $user, Enterprise $enterprise)
    {
        //
    }

    /**
     * Determine whether the user can restore the enterprise.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enterprise  $enterprise
     * @return mixed
     */
    public function restore(User $user, Enterprise $enterprise)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the enterprise.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enterprise  $enterprise
     * @return mixed
     */
    public function forceDelete(User $user, Enterprise $enterprise)
    {
        //
    }
}
