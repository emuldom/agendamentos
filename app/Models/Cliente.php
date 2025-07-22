<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    
    protected $table = 'clientes';
    public $timestamps = false;
    
    protected $fillable = [
        'empresa_id',
        'nome_completo',
        'numero_whatsapp',
        'email',
    ];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
    
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}