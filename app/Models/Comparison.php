<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comparison extends Model {
    use HasFactory;

    protected $fillable = ['project_id', 'option_id_1', 'option_id_2', 'state'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function option1()
    {
        return $this->belongsTo(Option::class, 'option_id_1');
    }

    public function option2()
    {
        return $this->belongsTo(Option::class, 'option_id_2');
    }
}
