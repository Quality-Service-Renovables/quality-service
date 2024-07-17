<h1 align="center">Quality Service</h1>
<p align="center">Versión 1.0.0</p>

## Application Web Service


Plantilla de proyecto Laravel con Vue 3, componentes incluidos

- Laravel 11
- Sail
- Sanctum
- Vue 3
- Vuetify
- Calidad (Php Cs Fixer, Code Sniffer, Mess Detector, Psalm, Php Stan)
- Pest (Pruebas unitarias)
- Qodana (Inspección de código JetBrains)

## Requerimientos

- Docker

## Instalación

1. Ingrese al directorio del proyecto.
2. Renombrar el archivo .env.example a .env (Modificarlo si es necesario)
3. Ejecute comando de instalación, se requiere para ejecutar instrucciones de sail.

   `docker run --rm --interactive --tty -v $(pwd):/app composer install`
4. Iniciar sail
   `./vendor/bin/sail up`
5. Ejecute de migraciones y seeders.
   `./vendor/bin/sail artisan command:start-project`
6. Instalar componentes
   `./vendor/bin/sail npm i`
7. Iniciar servidor
   `./vendor/bin/sail npm run dev`

## Configuración de alias

En el home de su usuario, en el archivo `.bashrc` o `.zshrc` dependiendo de la terminal que esté utilizando, pegue en la sección de alias las siguientes líneas

`alias sail="./vendor/bin/sail"`

`alias artisan="./vendor/bin/sail artisan"`

Ejecute el comando `. ~/.bashrc` (ejemplo para bashrc) o inicie de nuevo su terminal para cargar los nuevos alias.
Esto le permite abreviar la instruction de comandos. Por ejemplo, si quisiera listar las rutas solo introduzca el comando  `artisan route:list`
este será el equivalente a `./vendor/bin/sail artisan route:list` o si desea iniciar el servicio de sail
solo sería necesario ejecutar el comando `sail up` esto sería el equivalente a `./vendor/bin/sail up"`

## Documentación de Api
https://documenter.getpostman.com/view/17285993/2s93RRxtsU
