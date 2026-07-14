<?php

namespace App\Policies;

use App\Models\Notebook;
use App\Models\User;

class NotebookPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Notebook $notebook): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, Notebook $notebook): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function delete(User $user, Notebook $notebook): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function restore(User $user, Notebook $notebook): bool
    {
        return false;
    }

    public function forceDelete(User $user, Notebook $notebook): bool
    {
        return false;
    }
}
