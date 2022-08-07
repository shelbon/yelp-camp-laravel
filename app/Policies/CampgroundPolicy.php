<?php

namespace App\Policies;

use App\Models\Campground;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CampgroundPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Campground $campground
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Campground $campground)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Campground $campground
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(?User $user, Campground $campground)
    {
        return optional($user)->id === $campground->author
            ? Response::allow()
            : Response::deny("you can't edit this campground,it's not your own.");
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Campground $campground
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(?User $user, Campground $campground)
    {
        return optional($user)->id === $campground->author
            ? Response::allow()
            : Response::deny("you can't delete this campground,it's not your own.");
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Campground $campground
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Campground $campground)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Campground $campground
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Campground $campground)
    {
        //
    }
}
