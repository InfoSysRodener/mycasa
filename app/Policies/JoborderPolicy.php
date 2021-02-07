<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Joborder;
use Illuminate\Auth\Access\HandlesAuthorization;

class JoborderPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any joborders.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
        return true;
    }

    /**
     * Determine whether the user can view the joborder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Joborder  $joborder
     * @return mixed
     */
    public function view(User $user, Joborder $joborder)
    {
        //
        if($user->user_type !== 'consumer'){
            return true;
        }
        return $joborder->user_id === $user->id;
    }

    /**
     * Determine whether the user can create joborders.
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
     * Determine whether the user can update the joborder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Joborder  $joborder
     * @return mixed
     */
    public function update(User $user, Joborder $joborder)
    {
        //
        if($user->user_type === 'admin' || $user->user_type === 'technician' ){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the joborder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Joborder  $joborder
     * @return mixed
     */
    public function delete(User $user, Joborder $joborder)
    {
        //
    }

    /**
     * Determine whether the user can restore the joborder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Joborder  $joborder
     * @return mixed
     */
    public function restore(User $user, Joborder $joborder)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the joborder.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Joborder  $joborder
     * @return mixed
     */
    public function forceDelete(User $user, Joborder $joborder)
    {
        //
    }
}
