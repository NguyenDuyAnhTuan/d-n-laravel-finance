<?php
// app/Models/Income.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'date', 'amount', 'description', 'user_id'
    ];

    protected $casts = [
        'date' => 'date',
    ];
}