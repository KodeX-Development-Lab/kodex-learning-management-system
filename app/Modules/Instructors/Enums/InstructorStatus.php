<?php

namespace App\Modules\Instructors\Enums;

enum InstructorStatus: string {
    case PENDING   = 'Pending';
    case CANCELLED = 'Cancelled';
    case REJECTED  = 'Rejected';
    case FREEZE    = 'Freeze';
    case APPROVED  = 'Approved';
}
