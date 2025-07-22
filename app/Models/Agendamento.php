<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;
    
    protected $table = 'agendamentos';
    
    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'funcionario_id',
        'tipo_agendamento_id',
        'data_hora_agendamento',
        'status_agendamento',
        'origem_agendamento',
        'observacoes',
    ];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
    
    public function tipoAgendamento()
    {
        return $this->belongsTo(TipoAgendamento::class, 'tipo_agendamento_id');
    }
}