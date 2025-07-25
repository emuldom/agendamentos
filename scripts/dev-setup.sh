#!/bin/bash
# === SCRIPT DE CONFIGURAÇÃO PARA DESENVOLVIMENTO ===
# Sistema de Agendamentos - Setup DEV Environment

set -e

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Função para log
log() {
    echo -e "${BLUE}[$(date +'%Y-%m-%d %H:%M:%S')]${NC} $1"
}

log_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

log_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_error() {
    echo -e "${RED}❌ $1${NC}"
}

echo -e "${BLUE}"
echo "═══════════════════════════════════════════════════════════════"
echo "🚀 SISTEMA DE AGENDAMENTOS - CONFIGURAÇÃO DE DESENVOLVIMENTO"
echo "═══════════════════════════════════════════════════════════════"
echo -e "${NC}"

# Verificar se estamos no diretório correto
if [ ! -f "composer.json" ] || [ ! -f "artisan" ]; then
    log_error "Este script deve ser executado no diretório raiz do projeto Laravel!"
    exit 1
fi

log "Iniciando configuração do ambiente de desenvolvimento..."

# === VERIFICAÇÕES INICIAIS ===
log "📋 Verificando dependências..."

# Verificar Docker
if ! command -v docker &> /dev/null; then
    log_error "Docker não está instalado!"
    exit 1
fi

# Verificar Docker Compose
if ! command -v docker-compose &> /dev/null; then
    log_error "Docker Compose não está instalado!"
    exit 1
fi

log_success "Docker e Docker Compose encontrados"

# === CONFIGURAÇÃO DO AMBIENTE ===
log "🔧 Configurando arquivos de ambiente..."

# Copiar .env.dev para .env se não existir
if [ ! -f ".env" ]; then
    if [ -f ".env.dev" ]; then
        cp .env.dev .env
        log_success "Arquivo .env criado a partir do .env.dev"
    else
        log_error "Arquivo .env.dev não encontrado!"
        exit 1
    fi
else
    log_warning "Arquivo .env já existe, mantendo configuração atual"
fi

# === CRIAÇÃO DE DIRETÓRIOS ===
log "📁 Criando diretórios necessários..."

mkdir -p storage/logs
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/app/public
mkdir -p bootstrap/cache
mkdir -p database

log_success "Diretórios criados"

# === PERMISSÕES ===
log "🔐 Configurando permissões..."

chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Criar arquivo SQLite se não existir
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    chmod 664 database/database.sqlite
    log_success "Arquivo SQLite criado"
fi

# === DOCKER ===
log "🐳 Configurando ambiente Docker..."

# Parar containers existentes
if docker-compose -f docker-compose.dev.yml ps -q | grep -q .; then
    log "Parando containers existentes..."
    docker-compose -f docker-compose.dev.yml down
fi

# Construir imagens
log "🔨 Construindo imagens Docker..."
docker-compose -f docker-compose.dev.yml build --no-cache

# Iniciar containers
log "🚀 Iniciando containers..."
docker-compose -f docker-compose.dev.yml up -d

# Aguardar containers ficarem prontos
log "⏳ Aguardando containers ficarem prontos..."
sleep 15

# === CONFIGURAÇÃO DO LARAVEL ===
log "⚙️  Configurando Laravel..."

# Instalar dependências
log "📦 Instalando dependências PHP..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev composer install --dev

# Instalar dependências Node.js
log "📦 Instalando dependências Node.js..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev npm install

# Gerar chave da aplicação
log "🔑 Gerando chave da aplicação..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan key:generate --force

# Executar migrações
log "🗄️  Executando migrações..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan migrate --force

# Executar seeders (opcional)
read -p "Deseja executar os seeders? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    log "🌱 Executando seeders..."
    docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan db:seed --force
fi

# Criar link simbólico do storage
log "🔗 Criando link simbólico do storage..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan storage:link

# Limpar caches
log "🧹 Limpando caches..."
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan config:clear
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan route:clear
docker-compose -f docker-compose.dev.yml exec -T agendamentos_app_dev php artisan view:clear

# === VERIFICAÇÃO FINAL ===
log "🏥 Verificando saúde da aplicação..."

sleep 5

if curl -s http://localhost:8080 > /dev/null; then
    log_success "Aplicação está respondendo!"
else
    log_warning "Aplicação pode não estar totalmente pronta ainda"
fi

# === FINALIZAÇÃO ===
echo -e "${GREEN}"
echo "═══════════════════════════════════════════════════════════════"
echo "🎉 CONFIGURAÇÃO CONCLUÍDA COM SUCESSO!"
echo "═══════════════════════════════════════════════════════════════"
echo -e "${NC}"

echo -e "${BLUE}📱 URLs Disponíveis:${NC}"
echo "  🌐 Aplicação:     http://localhost:8080"
echo "  📧 MailHog:       http://localhost:8025"
echo "  🗄️  Adminer:       http://localhost:8082"
echo "  ⚡ Vite Dev:      http://localhost:5173"
echo ""
echo -e "${BLUE}🛠️  Comandos Úteis:${NC}"
echo "  make dev-logs     # Ver logs"
echo "  make dev-shell    # Acessar shell"
echo "  make dev-restart  # Reiniciar"
echo "  make help         # Ver todos os comandos"
echo ""
echo -e "${YELLOW}💡 Dica: Use 'make help' para ver todos os comandos disponíveis!${NC}"