FROM debian:bullseye-20240926-slim
# Variables
ENV APP_WORKDIR=/app \
    DEBIAN_FRONTEND=noninteractive \
    COMPOSER_ALLOW_SUPERUSER=1 \
    PATH_SCRIPTS=/scripts \
    VITE_APP_NAME=sso \
    VITE_API_URL=${VITE_API_URL} \
    VITE_PORT=5173
# Ubicación APP_WORKDIR proyecto de trabajo
WORKDIR ${APP_WORKDIR}
# Actualizar la lista de paquetes de Ubuntu
RUN apt-get update && apt-get upgrade -y && apt-get install -y --no-install-recommends --fix-missing -y \
    lsb-release apt-transport-https ca-certificates build-essential software-properties-common dirmngr gnupg2 \
    wget curl
# Añade el repositorio de PHP 8.3
RUN curl -sSLo /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/php.list
# Instalación de PHP 8.3
RUN apt-get update -y && apt-get install -y --no-install-recommends --fix-missing -y\
    cron openssh-server nginx \
    php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-xml php8.3-mbstring \
    php8.3-curl php8.3-zip php8.3-gd php8.3-intl php8.3-soap php8.3-bcmath \
    php8.3-opcache php8.3-redis nodejs
# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --2
# Instalar Node.js 20
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs
# Certificado SSL autodirigido
RUN mkdir -p /etc/nginx/ssl/ && \
    openssl req -x509 -nodes -days 965 -newkey rsa:2048 \
    -keyout /etc/nginx/ssl/nginx.key -out /etc/nginx/ssl/nginx.crt \
    -subj "/C=MX/ST=CDMX/L=CDMX/O=TAAG/OU=TIDev/CN=localhost"
# Limpieza
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Directorios
COPY --chown=root:root .docker/php.ini    /etc/php/8.3/fpm/php.ini
COPY --chown=root:root .docker/nginx.conf /etc/nginx/sites-enabled/default
COPY --chown=root:root .docker/php-fpm.conf /etc/php/8.3/fpm/pool.d/www.conf
COPY --chown=root:root .docker/sshd_config /etc/ssh/
COPY --chown=root:root .docker/authorized_keys /root/.ssh/authorized_keys
COPY --chown=root:root .docker/start.sh .docker/background.sh ${PATH_SCRIPTS}/
COPY --chown=root:root .docker/cron-job /etc/cron.d/cron-job
COPY . .
# Asignar permisos
RUN chmod +x ${PATH_SCRIPTS}/start.sh ${PATH_SCRIPTS}/background.sh && \
    chmod 600 /root/.ssh/authorized_keys
# Instalar dependencias PHP y JS
RUN composer install --no-dev --optimize-autoloader --prefer-dist --no-interaction && \
    composer dump-autoload && \
    npm install && npm run build
# Cron y logs
RUN chmod 0644 /etc/cron.d/cron-job && \
    crontab /etc/cron.d/cron-job && \
    touch /var/log/cron.log
# Puertos
EXPOSE 22 80 443 5173
# Scripting
CMD ["/scripts/start.sh"]
