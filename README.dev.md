# 🚀 Sistema de Agendamentos - Ambiente de Desenvolvimento

## 📋 Pré-requisitos

- Docker 20.10+
- Docker Compose 2.0+
- Make (opcional, mas recomendado)

## 🔧 Configuração Inicial

### Opção 1: Setup Automático (Recomendado)

```bash
# Tornar o script executável
chmod +x scripts/dev-setup.sh

# Executar configuração automática
./scripts/dev-setup.sh
```

### Opção 2: Setup Manual

```bash
# 1. Configurar ambiente
cp .env.dev .env

# 2. Construir e iniciar containers
make dev-setup

# OU usando docker-compose diretamente
docker-compose -f docker-compose.dev.yml up -d --build
```

## 🎯 URLs de Desenvolvimento

| Serviço | URL | Descrição |
|---------|-----|-----------|
| **Aplicação** | http://localhost:8080 | Sistema principal |
| **MailHog** | http://localhost:8025 | Interface de emails |
| **Adminer** | http://localhost:8082 | Gerenciador de banco |
| **Vite Dev** | http://localhost:5173 | Servidor de desenvolvimento |
| **Redis** | localhost:6379 | Banco Redis |

## 🛠️ Comandos Disponíveis

### Gerenciamento Básico
```bash
make dev-up        # Iniciar ambiente
make dev-down      # Parar ambiente
make dev-restart   # Reiniciar ambiente
make dev-logs      # Ver logs
make dev-shell     # Acessar shell do container
```

### Laravel
```bash
make artisan CMD="migrate"           # Executar migrações
make artisan CMD="db:seed"           # Executar seeders
make artisan CMD="make:controller"   # Criar controller
make composer CMD="require package" # Instalar pacote
```

### Frontend
```bash
make npm CMD="install"     # Instalar dependências
make npm CMD="run build"   # Build de produção
make npm CMD="run dev"     # Servidor de desenvolvimento
```

### Utilitários
```bash
make dev-clean     # Limpar recursos Docker
make dev-status    # Status dos containers
make dev-health    # Verificar saúde da aplicação
```

## 🐛 Debug e Desenvolvimento

### Xdebug
O Xdebug está configurado e pronto para uso:
- **Porta:** 9003
- **IDE Key:** PHPSTORM
- **Host:** host.docker.internal

### Logs
```bash
# Ver todos os logs
make dev-logs

# Logs específicos
docker-compose -f docker-compose.dev.yml logs agendamentos_app_dev
docker-compose -f docker-compose.dev.yml logs agendamentos_nginx_dev
```

### Hot Reload
- **PHP:** Mudanças são refletidas automaticamente
- **Frontend:** Vite HMR ativo em http://localhost:5173

## 📊 Banco de Dados

### SQLite (Padrão para DEV)
- **Arquivo:** `database/database.sqlite`
- **Acesso via Adminer:** http://localhost:8082
  - Sistema: SQLite 3
  - Banco: `/var/www/html/database/database.sqlite`

### Migrações e Seeders
```bash
# Executar migrações
make artisan CMD="migrate"

# Executar seeders
make artisan CMD="db:seed"

# Reset completo
make artisan CMD="migrate:fresh --seed"
```

## 📧 Emails (MailHog)

Todos os emails são capturados pelo MailHog:
- **Interface:** http://localhost:8025
- **SMTP:** localhost:1025

## 🔧 Troubleshooting

### Container não inicia
```bash
# Verificar logs
make dev-logs

# Reconstruir imagens
make dev-build

# Reset completo
make dev-down && make dev-clean && make dev-setup
```

### Permissões
```bash
# Corrigir permissões
sudo chown -R $USER:$USER .
chmod -R 775 storage bootstrap/cache
```

### Cache
```bash
# Limpar todos os caches
make artisan CMD="optimize:clear"
```

## 🚀 Workflow de Desenvolvimento

1. **Iniciar ambiente:** `make dev-up`
2. **Desenvolver:** Editar arquivos normalmente
3. **Ver logs:** `make dev-logs` (em outro terminal)
4. **Testar:** http://localhost:8080
5. **Parar ambiente:** `make dev-down`

## 📝 Notas Importantes

- ✅ Hot reload ativo para PHP e frontend
- ✅ Xdebug configurado
- ✅ Logs detalhados
- ✅ SQLite para simplicidade
- ✅ MailHog para emails
- ✅ Adminer para banco
- ✅ Comandos automatizados via Makefile

---

**💡 Dica:** Use `make help` para ver todos os comandos disponíveis!