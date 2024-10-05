<?php

namespace App\Modules\Course\Policies;

use App\Models\User;
use App\Modules\Course\Model\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstructorCoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Modules\Users\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manage(User $user, Course $course)
    {
        if ($course->user_id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Modules\Users\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Course $course)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Modules\Users\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Modules\Users\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user)
    {
        //
    }
}
