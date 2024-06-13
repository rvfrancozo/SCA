<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'decision_area_id', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function decisionArea()
    {
        return $this->belongsTo(DecisionArea::class);
    }
}
