<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class ParentUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'parent_id',
    ];


    public function partner()
    {
        return $this->hasOne(ParentUser::class, 'id', 'partner_id');
    }
}
