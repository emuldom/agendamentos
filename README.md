# 🚀 Laravel 12 Docker - Arquitetura Segura

Uma arquitetura Docker completa e segura para aplicações Laravel 12 com PHP 8.3, seguindo as melhores práticas de segurança e performance.

## 🔐 Características de Segurança

### Container Security
- ✅ **Non-root user**: Container executa como usuário não-privilegiado (`appuser`)
- ✅ **Read-only filesystem**: Sistema de arquivos somente leitura com volumes tmpfs para áreas necessárias
- ✅ **Capabilities dropped**: Todas as capabilities removidas, apenas as essenciais adicionadas
- ✅ **No new privileges**: Previne escalação de privilégios
- ✅ **Resource limits**: Limites de CPU e memória definidos
- ✅ **Multi-stage build**: Imagem otimizada sem dependências de build em produção

### Application Security
- ✅ **PHP hardening**: Funções perigosas desabilitadas, configurações seguras
- ✅ **Session security**: Cookies seguros, HttpOnly, SameSite
- ✅ **Security headers**: X-Frame-Options, X-Content-Type-Options, CSP, etc.
- ✅ **Rate limiting**: Proteção contra ataques de força bruta e DoS
- ✅ **Input validation**: Configurações PHP seguras para uploads e inputs
- ✅ **OPcache**: Cache de bytecode otimizado para performance

### Network Security
- ✅ **Reverse proxy ready**: Configurado para funcionar com Nginx Proxy Manager
- ✅ **Internal communication**: Comunicação segura via sockets Unix
- ✅ **Firewall friendly**: Apenas porta 8080 exposta
- ✅ **Health checks**: Monitoramento de saúde da aplicação

## 📁 Estrutura do Projeto

```
├── docker/
│   ├── nginx/
│   │   ├── nginx.conf          # Configuração principal do Nginx
│   │   └── default.conf        # Virtual host da aplicação
│   ├── php/
│   │   ├── php.ini             # Configurações PHP seguras
│   │   ├── opcache.ini         # Configurações OPcache
│   │   └── php-fpm.conf        # Configurações PHP-FPM
│   └── supervisor/
│       └── supervisord.conf    # Gerenciamento de processos
├── scripts/
│   ├── build-and-deploy.sh     # Script de build e deploy
│   └── security-check.sh       # Verificação de segurança
├── Dockerfile                  # Multi-stage Docker build
├── docker-compose.yml          # Orquestração de containers
├── Makefile                    # Comandos úteis
└── .env.production             # Variáveis de ambiente de produção
```

## 🚀 Quick Start

### 1. Preparação
```bash
# Clone ou prepare seu projeto Laravel 12
git clone <seu-repositorio>
cd <seu-projeto>

# Copie os arquivos de configuração Docker
# (cole todos os arquivos dos artifacts acima na estrutura correta)
```

### 2. Configuração
```bash
# Configure as variáveis de ambiente
cp .env.production .env

# Gere a chave da aplicação (se necessário)
php artisan key:generate
```

### 3. Deploy
```bash
# Opção 1: Deploy automático
make deploy

# Opção 2: Deploy manual
chmod +x scripts/build-and-deploy.sh
./scripts/build-and-deploy.sh

# Opção 3: Comandos individuais
make build
make up
make setup
```

## 🛠️ Comandos Úteis (Makefile)

```bash
# Gerenciamento básico
make up              # Inicia containers
make down            # Para containers
make restart         # Reinicia containers
make logs            # Visualiza logs

# Desenvolvimento
make shell           # Acessa shell do container
make artisan CMD="migrate"     # Executa comando artisan
make composer CMD="install"    # Executa comando composer

# Monitoramento
make health          # Verifica saúde da aplicação
make security-check  # Executa verificação de segurança
make stats           # Mostra estatísticas dos containers

# Manutenção
make clean           # Remove recursos não utilizados
make fresh-install   # Instalação completa do zero
make backup-db       # Backup do banco de dados
```

## 🔧 Configurações Importantes

### PHP Security Settings
- `expose_php = Off` - Oculta versão do PHP
- `allow_url_fopen = Off` - Previne inclusão de URLs remotas
- `disable_functions` - Funções perigosas desabilitadas
- Session cookies seguros e HttpOnly

### Nginx Security
- Server tokens ocultos
- Headers de segurança configurados
- Rate limiting implementado
- Negação de acesso a arquivos sensíveis

### Container Hardening
- Execução como usuário não-root
- Filesystem read-only
- Capabilities mínimas
- Resource limits aplicados

## 📊 Monitoramento e Logs

### Health Checks
```bash
# Verificação manual
curl http://localhost:8080/health

# Via Makefile
make health
```

### Logs
```bash
# Logs em tempo real
make logs

# Últimos 50 logs
make logs-tail

# Logs específicos
docker-compose logs laravel_app
```

### Métricas
```bash
# Estatísticas do container
make stats

# Status dos containers
make ps
```

## 🚨 Verificação de Segurança

Execute regularmente a verificação de segurança:

```bash
make security-check
```

Este script verifica:
- Execução como usuário não-root
- Permissões de arquivos
- Configurações PHP seguras
- Headers de segurança
- Processos em execução

## 🔗 Integração com Nginx Proxy Manager

A aplicação está configurada para funcionar com Nginx Proxy Manager na rede `infra_main_app_network`. Configure seu proxy para:

- **Target**: `http://laravel_agendamentos:8080`
- **Health Check**: `/health`
- **Headers**: Preserve host headers

## 📈 Performance

### Otimizações Implementadas
- OPcache configurado para máxima performance
- Nginx com compressão gzip
- Cache de configurações Laravel
- Multi-stage build para imagens menores
- Supervisor para gerenciamento eficiente de processos

### Resource Limits
- **CPU**: 1.0 core (limit), 0.25 core (reserved)
- **Memory**: 512MB (limit), 256MB (reserved)
- **Logging**: Rotação automática (10MB, 3 arquivos)

## 🛡️ Melhores Práticas Implementadas

1. **Principle of Least Privilege**: Container executa com mínimas permissões
2. **Defense in Depth**: Múltiplas camadas de segurança
3. **Fail Secure**: Configurações seguras por padrão
4. **Monitoring**: Health checks e logging abrangente
5. **Immutable Infrastructure**: Containers são imutáveis e replaceable
6. **Secret Management**: Senhas via environment variables
7. **Network Segmentation**: Rede isolada para a aplicação

## 🔄 Atualizações e Manutenção

### Deploy de Novas Versões
```bash
# Atualizar aplicação
git pull
make deploy

# Backup antes de atualizações importantes
make backup-db
```

### Limpeza Regular
```bash
# Remove recursos não utilizados
make clean

# Restart periódico (se necessário)
make restart
```

## 📞 Suporte

Para problemas ou dúvidas:

1. Verifique os logs: `make logs`
2. Execute verificação de segurança: `make security-check`
3. Verifique saúde da aplicação: `make health`
4. Consulte a documentação do Laravel 12

---

**⚠️ Importante**: Sempre teste as configurações em ambiente de desenvolvimento antes de aplicar em produção. Ajuste as configurações conforme suas necessidades específicas de segurança e performance.