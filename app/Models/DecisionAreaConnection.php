<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionAreaConnection extends Model
{
    use HasFactory;

    protected $fillable = [
        'decision_area_id_1',
        'decision_area_id_2',
        'project_id',
    ];
}
