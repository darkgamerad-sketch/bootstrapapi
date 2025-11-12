<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre',
        'descripcion',
        'finalizada',
        'fecha_limite',
        'urgencia',
    ];

    protected $casts = [
        'fecha_limite' => 'datetime',
        'finalizada' => 'boolean',
    ];

    // Si agregaste user_id, descomenta esto:
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Método para obtener el texto de urgencia
    public function getUrgenciaTextoAttribute()
    {
        return match($this->urgencia) {
            0 => 'No urgente',
            1 => 'Urgencia normal',
            2 => 'Muy urgente',
            default => 'Desconocido',
        };
    }

    // Método para obtener la clase CSS de urgencia
    public function getUrgenciaClaseAttribute()
    {
        return match($this->urgencia) {
            0 => 'success',
            1 => 'warning',
            2 => 'danger',
            default => 'secondary',
        };
    }
}
