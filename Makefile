# === MAKEFILE PARA DESENVOLVIMENTO ===
# Sistema de Agendamentos - Comandos Automatizados
# Uso: make <comando>

.PHONY: help dev-up dev-down dev-restart dev-logs dev-shell dev-build dev-clean dev-setup

# === CONFIGURAÇÕES ===
DOCKER_COMPOSE_DEV = docker-compose -f docker-compose.dev.yml
DOCKER_COMPOSE_PROD = docker-compose -f docker-compose.yml
CONTAINER_APP = agendamentos_app_dev
CONTAINER_NGINX = agendamentos_nginx_dev
CONTAINER_REDIS = redis_agendamentos_dev

# === HELP ===
help: ## Mostra esta ajuda
	@echo "🚀 Sistema de Agendamentos - Comandos Disponíveis:"
	@echo ""
	@echo "📦 DESENVOLVIMENTO:"
	@echo "  dev-setup     - Configuração inicial do ambiente de desenvolvimento"
	@echo "  dev-up        - Inicia ambiente de desenvolvimento"
	@echo "  dev-down      - Para ambiente de desenvolvimento"
	@echo "  dev-restart   - Reinicia ambiente de desenvolvimento"
	@echo "  dev-build     - Reconstrói imagens de desenvolvimento"
	@echo ""
	@echo "🔧 UTILITÁRIOS:"
	@echo "  dev-logs      - Visualiza logs do ambiente de desenvolvimento"
	@echo "  dev-shell     - Acessa shell do container da aplicação"
	@echo "  dev-redis     - Acessa CLI do Redis"
	@echo "  dev-clean     - Limpa recursos não utilizados"
	@echo ""
	@echo "🎯 LARAVEL:"
	@echo "  artisan CMD=  - Executa comando artisan (ex: make artisan CMD=migrate)"
	@echo "  composer CMD= - Executa comando composer (ex: make composer CMD=install)"
	@echo "  npm CMD=      - Executa comando npm (ex: make npm CMD=install)"
	@echo ""
	@echo "📊 MONITORAMENTO:"
	@echo "  dev-status    - Status dos containers"
	@echo "  dev-health    - Verifica saúde da aplicação"
	@echo "  dev-stats     - Estatísticas dos containers"
	@echo ""
	@echo "🏭 PRODUÇÃO:"
	@echo "  prod-up       - Inicia ambiente de produção"
	@echo "  prod-down     - Para ambiente de produção"
	@echo "  prod-logs     - Logs do ambiente de produção"

# === DESENVOLVIMENTO ===
dev-setup: ## Configuração inicial do ambiente de desenvolvimento
	@echo "🔧 Configurando ambiente de desenvolvimento..."
	@if [ ! -f .env.dev ]; then echo "❌ Arquivo .env.dev não encontrado!"; exit 1; fi
	@cp .env.dev .env
	@echo "✅ Arquivo .env configurado"
	@$(DOCKER_COMPOSE_DEV) build --no-cache
	@echo "✅ Imagens construídas"
	@$(DOCKER_COMPOSE_DEV) up -d
	@echo "✅ Containers iniciados"
	@echo "⏳ Aguardando inicialização..."
	@sleep 10
	@echo "🎉 Ambiente de desenvolvimento pronto!"
	@echo ""
	@echo "📱 URLs Disponíveis:"
	@echo "  🌐 Aplicação:     http://localhost:8080"
	@echo "  📧 MailHog:       http://localhost:8025"
	@echo "  🗄️  Adminer:       http://localhost:8082"
	@echo "  ⚡ Vite Dev:      http://localhost:5173"

dev-up: ## Inicia ambiente de desenvolvimento
	@echo "🚀 Iniciando ambiente de desenvolvimento..."
	@$(DOCKER_COMPOSE_DEV) up -d
	@echo "✅ Ambiente iniciado!"

dev-down: ## Para ambiente de desenvolvimento
	@echo "🛑 Parando ambiente de desenvolvimento..."
	@$(DOCKER_COMPOSE_DEV) down
	@echo "✅ Ambiente parado!"

dev-restart: ## Reinicia ambiente de desenvolvimento
	@echo "🔄 Reiniciando ambiente de desenvolvimento..."
	@$(DOCKER_COMPOSE_DEV) restart
	@echo "✅ Ambiente reiniciado!"

dev-build: ## Reconstrói imagens de desenvolvimento
	@echo "🔨 Reconstruindo imagens..."
	@$(DOCKER_COMPOSE_DEV) build --no-cache
	@echo "✅ Imagens reconstruídas!"

dev-clean: ## Limpa recursos não utilizados
	@echo "🧹 Limpando recursos..."
	@docker system prune -f
	@docker volume prune -f
	@echo "✅ Limpeza concluída!"

# === UTILITÁRIOS ===
dev-logs: ## Visualiza logs do ambiente de desenvolvimento
	@$(DOCKER_COMPOSE_DEV) logs -f

dev-shell: ## Acessa shell do container da aplicação
	@echo "🐚 Acessando shell do container..."
	@$(DOCKER_COMPOSE_DEV) exec $(CONTAINER_APP) sh

dev-redis: ## Acessa CLI do Redis
	@echo "📊 Acessando Redis CLI..."
	@$(DOCKER_COMPOSE_DEV) exec $(CONTAINER_REDIS) redis-cli

# === LARAVEL ===
artisan: ## Executa comando artisan (ex: make artisan CMD=migrate)
	@$(DOCKER_COMPOSE_DEV) exec $(CONTAINER_APP) php artisan $(CMD)

composer: ## Executa comando composer (ex: make composer CMD=install)
	@$(DOCKER_COMPOSE_DEV) exec $(CONTAINER_APP) composer $(CMD)

npm: ## Executa comando npm (ex: make npm CMD=install)
	@$(DOCKER_COMPOSE_DEV) exec $(CONTAINER_APP) npm $(CMD)

# === MONITORAMENTO ===
dev-status: ## Status dos containers
	@echo "📊 Status dos containers:"
	@$(DOCKER_COMPOSE_DEV) ps

dev-health: ## Verifica saúde da aplicação
	@echo "🏥 Verificando saúde da aplicação..."
	@curl -s http://localhost:8080/health || echo "❌ Aplicação não está respondendo"

dev-stats: ## Estatísticas dos containers
	@echo "📈 Estatísticas dos containers:"
	@docker stats --no-stream

# === PRODUÇÃO ===
prod-up: ## Inicia ambiente de produção
	@echo "🏭 Iniciando ambiente de produção..."
	@$(DOCKER_COMPOSE_PROD) up -d

prod-down: ## Para ambiente de produção
	@echo "🛑 Parando ambiente de produção..."
	@$(DOCKER_COMPOSE_PROD) down

prod-logs: ## Logs do ambiente de produção
	@$(DOCKER_COMPOSE_PROD) logs -f

# === COMANDOS RÁPIDOS ===
dev: dev-up ## Alias para dev-up
stop: dev-down ## Alias para dev-down
logs: dev-logs ## Alias para dev-logs
shell: dev-shell ## Alias para dev-shell