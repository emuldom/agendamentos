<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAgendamento extends Model
{
    use HasFactory;
    
    protected $table = 'tipos_de_agendamento';
    public $timestamps = false;
    
    protected $fillable = [
        'empresa_id',
        'nome_servico',
        'descricao',
        'duracao_estimada_min',
        'valor',
    ];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'tipo_agendamento_id');
    }
}