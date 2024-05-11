<?php

namespace App\Models\Tenants;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'content', 'user_id',];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWithUser(Builder $builder, int $userID = null)
    {
        if (!$userID) {
            $userID = Auth::id();
        }
        $builder->where('user_id', $userID);
    }
}
