<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DecisionArea extends Model
{
    use HasFactory;

    protected $fillable = ['label', 'description', 'importancy', 'urgency', 'isFocused', 'project_id'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function connections()
    {
        return $this->belongsToMany(DecisionArea::class, 'decision_area_connections', 'decision_area_id_1', 'decision_area_id_2');
    }

    public function options() {
        return $this->hasMany(Option::class);
    }
}
