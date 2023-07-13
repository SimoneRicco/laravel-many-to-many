<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Slugger;

class Project extends Model
{
    use HasFactory;
    use Slugger;

    public function type()
    {
        // belongsTo si usa nel model della tabella che ha la chiave esterna, di conseguenza quella che sta dalla parte del molti
        return $this->belongsTo(Type::class);
    }
    public function technologies()
    {
        return $this->belongsToMany(Technology::class);
    }
    public function getRouteKey()
    {
        return $this->slug;
    }
}
