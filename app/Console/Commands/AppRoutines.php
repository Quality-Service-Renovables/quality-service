<?php

namespace App\Console\Commands;

use App\Services\Service;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\Isolatable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
     *
     * @throws \JsonException
     */
    public function handle(): void
    {
        // Ejecuta tareas de rutina
        $this->mainRoutine();
        $this->purgeModules();
        $this->info('Process complete');
    }

    private function mainRoutine(): void
    {
        $this->line('Executing maintenance routines from artisan...');
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
        //Artisan::call('route:cache');
        Artisan::call('config:cache');
        Artisan::call('view:cache');
        // Actualización de composer
        $this->line('Optimizing composer');
        $commandComposer = shell_exec('composer dump-autoload --optimize');
    }

    /**
     * @throws \JsonException
     */
    private function purgeModules(): void
    {
        $this->line('Searching orphans document');
        $service = new Service();

        $modules = $service->getApplicationPaths();
        // Depurar módulos que cuenten con directorios
        foreach ($modules as $module => $folders) {
            if (is_array($folders) || is_object($folders)) {
                $this->purgeFiles($module, $folders);
            }
        }
    }

    public function purgeFiles($module, $folders): void
    {
        foreach ($folders as $folder) {
            // obtener todos los archivos en el directorio
            $files = Storage::disk('public_direct')->files($folder);
            foreach ($files as $file) {
                $this->searchInDb($module, $file);
            }
        }
    }

    private function searchInDb($module, $file): void
    {
        $models = $this->getModels();
        $table = $models[$module]['table'];
        $columns = $models[$module]['columns'];
        // obtenga el nombre del archivo del path
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        if ($fileName !== 'default') {
            // revisa si el archivo tiene un registro en la base de datos
            $fileInDatabase = DB::table($table);

            foreach ($columns as $key => $column) {
                $fileInDatabase->where($column, '=', $file);
                if ($key) {
                    $fileInDatabase->where($column, '=', $file);
                } else {
                    $fileInDatabase->orWhere($column, '=', $file);
                }
            }

            $fileExist = $fileInDatabase->first();
            // si el archivo no existe en la base de datos, lo elimina
            if (! $fileExist) {
                $this->warn('Deleting orphan document: '.$file);
                Storage::disk('public_direct')->delete($file);
            }
        }
    }

    private function getModels(): array
    {
        return [
            'equipments' => [
                'table' => 'equipments',
                'columns' => [
                    'equipment_image',
                    'equipment_diagram',
                    'manual',
                ],
            ],
            'evidences' => [
                'table' => 'inspection_evidences',
                'columns' => [
                    'inspection_evidence',
                    'inspection_evidence_secondary',
                ],
            ],
            'clients' => [
                'table' => 'clients',
                'columns' => [
                    'logo',
                ],
            ],
            'users' => [
                'table' => 'users',
                'columns' => [
                    'image_profile',
                ],
            ],
        ];
    }
}
