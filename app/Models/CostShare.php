<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class CostShare extends Model
{
    use HasFactory;
    use AsSource;

    protected $fillable = [
        'prod_code',
        'prod_name',
        'date',
        'quotes'
    ];

}
