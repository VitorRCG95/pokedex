# imagem do php utilizando a versão 8.2
FROM php:8.2-cli

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql gd

# Caminho do diretório dos arquivos do prejeto no container
WORKDIR /var/www

# Copia o projeto para o container
COPY . .

# Instala o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala as dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Dá permissão de escrita nas pastas storage e bootstrap/cache
RUN chmod -R 777 storage bootstrap/cache

# Expõe a porta 8000 para o Laravel servir a aplicação
EXPOSE 8000

# Comando para iniciar o servidor embutido do Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
