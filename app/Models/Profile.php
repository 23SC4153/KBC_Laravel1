<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserAccount;

class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(UserAccount::class, 'userId');
    }
}
