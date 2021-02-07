<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ads;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdsPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any ads.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the ads.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ads  $ads
     * @return mixed
     */
    public function view(User $user, Ads $ads)
    {
        //
    }

    /**
     * Determine whether the user can create ads.
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
     * Determine whether the user can update the ads.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ads  $ads
     * @return mixed
     */
    public function update(User $user, Ads $ads)
    {
        //
        if($user->user_type === 'admin'){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the ads.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ads  $ads
     * @return mixed
     */
    public function delete(User $user, Ads $ads)
    {
        //
    }

    /**
     * Determine whether the user can restore the ads.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ads  $ads
     * @return mixed
     */
    public function restore(User $user, Ads $ads)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ads.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Ads  $ads
     * @return mixed
     */
    public function forceDelete(User $user, Ads $ads)
    {
        //
    }
}
