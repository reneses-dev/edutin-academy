<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    use HandlesAuthorization;
    
    public function published(?User $user, Category $article): bool
    {
        if ($article->status == 1) {
            return true;
        }else {
            return false;
        }
    }
}
