<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Artisan;

class AppRoutines extends Command implements Isolatable
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:routines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta rutinas de mantenimiento de la aplicación,
    favor de leer el Readme para mayor información.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // Ejecuta tareas de rutina
        $this->mainRoutine();
    }

    private function mainRoutine(): void
    {
        $this->line('Ejecutando rutinas de mantenimiento artisan...');
        // Elimina caché
        Artisan::call('cache:clear');
        // Elimina configuración
        Artisan::call('config:clear');
        // Elimina vistas
        Artisan::call('view:clear');
        /*
         * Esto puede mejorar el rendimiento ya que las rutas no se reconstruirán
         * en cada solicitud. Si estás trabajando en tu entorno local,
         * no debes usar este comando ya que todas las rutas seguirán
         * siendo cacheadas.
         */
        Artisan::call('route:cache');
        Artisan::call('config:cache');
        Artisan::call('view:cache');
        // Actualización de composer
        $this->line('Refrescando composer...');
        $commandComposer = shell_exec('composer dump-autoload --optimize');
    }
}
