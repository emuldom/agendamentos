<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Usuario extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = 'usuarios';
    
    protected $fillable = [
        'empresa_id',
        'funcionario_id',
        'nome_usuario',
        'email_login',
        'senha_hash',
        'nivel_acesso',
        'ativo',
    ];
    
    protected $hidden = [
        'senha_hash',
    ];
    
    protected $casts = [
        'ativo' => 'boolean',
    ];
    
    public function getAuthPassword()
    {
        return $this->senha_hash;
    }
    
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    
    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class, 'funcionario_id');
    }
}