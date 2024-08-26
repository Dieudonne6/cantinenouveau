<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contrat;

class Eleve extends Model
{
    use HasFactory;
    protected $table = 'eleve';
    public function contrats()
    {
        return $this->hasMany(Contrat::class,'eleve_contrat', 'MATRICULE');
    }
    protected static function booted()
    {
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('NOM', 'asc');
        });
    }
}
