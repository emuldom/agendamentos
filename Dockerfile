# Dockerfile

# --- STAGE 1: base ---
# Define a imagem base para todos os estágios. php:8.3-fpm-alpine é leve e otimizada para PHP-FPM.
FROM php:8.3-fpm-alpine AS base

# Instalar dependências do sistema necessárias para compilação de extensões PHP e Node.js
# e ferramentas essenciais.
# As dependências de build são adicionadas aqui para estarem disponíveis para as extensões.
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    postgresql-dev \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    icu-dev \
    nodejs \
    npm \
    supervisor \
    # Dependências de build para extensões PHP como Redis
    autoconf \
    dpkg-dev dpkg \
    file \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c

# Instalar e configurar extensões PHP essenciais.
# --with-freetype --with-jpeg --with-webp são para a extensão GD.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    intl

# Instalar a extensão Redis para PHP via PECL.
# As dependências de build (autoconf, etc.) já estão instaladas no início do estágio 'base'.
RUN pecl install redis \
    && docker-php-ext-enable redis

# Copiar arquivos de configuração PHP personalizados para a imagem.
# php.ini: Configurações gerais do PHP.
# opcache.ini: Otimizações de desempenho do PHP (OPcache).
# php-fpm.conf: Configurações do PHP-FPM (process manager).
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Instalar Composer, copiando-o de uma imagem oficial do Composer para garantir a versão mais recente.
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho padrão para todos os estágios subsequentes.
WORKDIR /var/www/html

# --- STAGE 2: builder ---
# Este estágio é responsável por instalar todas as dependências PHP e Node.js,
# e compilar os assets da aplicação.
FROM base AS builder

# Copiar todo o código da aplicação para este estágio.
# O .dockerignore deve excluir 'vendor/' e 'node_modules/' do seu contexto local.
COPY . .

# Instalar dependências PHP usando Composer.
# Adicionamos '-v' para saída mais verbosa.
# --no-dev: Não instala dependências de desenvolvimento.
# --no-interaction: Não pede interação.
# --optimize-autoloader: Otimiza o autoloader para desempenho em produção.
# Os scripts do Composer (como post-autoload-dump) terão acesso ao 'artisan' aqui.
RUN composer install -v --no-dev --no-interaction --optimize-autoloader

# --------------------------------------------------------------------------

# Instalar dependências Node.js.
# 'npm install' instalará também as 'devDependencies' necessárias para o build dos assets.
RUN npm install

# Construir os assets de frontend (JavaScript, CSS, etc.) usando o script 'build' definido no package.json.
RUN npm run build

# Remover a pasta node_modules após o build, pois ela não é necessária na imagem final de produção.
RUN rm -rf node_modules

# --- STAGE 3: production ---
# Este é o estágio final, que será a imagem de produção.
# Ele será o mais leve possível, contendo apenas o essencial para rodar a aplicação.
FROM base AS production

# Definir o diretório de trabalho.
WORKDIR /var/www/html

# Copiar o código da aplicação (excluindo 'vendor/' e 'node_modules/' pelo .dockerignore).
COPY . .

# Copiar a pasta 'vendor' (com as dependências PHP) já construída e otimizada do estágio 'builder'.
COPY --from=builder /var/www/html/vendor ./vendor

# Copiar configurações do Supervisor para gerenciar processos (PHP-FPM, workers, etc.).
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Criar todos os diretórios necessários para a aplicação Laravel
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache/data \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/storage/app/public \
    && mkdir -p /var/www/html/bootstrap/cache \
    && mkdir -p /var/www/html/database \
    && mkdir -p /var/log/supervisor

# Criar o arquivo de banco de dados SQLite
RUN touch /var/www/html/database/database.sqlite

# Configurar permissões corretas para www-data (usuário padrão do PHP-FPM no Alpine)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && chmod 664 /var/www/html/database/database.sqlite

# Expor a porta 9000, que é a porta padrão para PHP-FPM.
EXPOSE 9000

# Definir o comando padrão para iniciar o Supervisor quando o contêiner for iniciado.
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
