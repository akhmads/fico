<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Journal;

class JournalPolicy
{
    public function __construct()
    {
        //
    }

    public function update(User $user, Journal $journal): bool
    {
        return $journal->status->value == 'open';
    }

    public function approve(User $user, Journal $journal): bool
    {
        return $journal->status->value == 'open';
    }
}
