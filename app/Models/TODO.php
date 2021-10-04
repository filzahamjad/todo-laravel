<?php

namespace App\Models;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class TODO extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    use Uuid;

    public $incrementing = false;
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    protected $casts = [
        'id' => 'string'
        ]; 
}
