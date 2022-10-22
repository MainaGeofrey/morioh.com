<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apikeys extends Model
{
    use HasFactory;
    protected $table = 'api_keys';

    protected $fillable = [
        'api_token',
        'user_id',
        'token_name'
    ];
}
