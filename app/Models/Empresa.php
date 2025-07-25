<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    
    protected $table = 'empresas';
    public $timestamps = false;
    
    protected $fillable = [
        'nome_empresa',
        'cnpj',
        'telefone_contato',
        'email_contato',
    ];
    
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
    
    public function funcionarios()
    {
        return $this->hasMany(Funcionario::class);
    }
    
    public function tiposDeAgendamento()
    {
        return $this->hasMany(TipoAgendamento::class);
    }
    
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
    
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}