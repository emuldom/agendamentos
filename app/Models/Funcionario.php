<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    
    protected $table = 'funcionarios';
    public $timestamps = false;
    
    protected $fillable = [
        'empresa_id',
        'nome_completo',
        'cargo',
        'email_profissional',
        'telefone_contato',
        'ativo',
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
    ];
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'funcionario_id');
    }
    
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'funcionario_id');
    }
}