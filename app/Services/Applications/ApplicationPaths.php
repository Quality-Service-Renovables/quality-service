<?php
/**
 * Paths Trait.
 *
 * Get application paths
 *
 * @author   Luis Adrian Olvera Facio
 *
 * @version  1.0
 *
 * @since    2024.1
 */

/** @noinspection UnknownInspectionInspection */
/** @noinspection PhpUndefinedFieldInspection */
/** @noinspection PhpUndefinedMethodInspection */

namespace App\Services\Applications;

/**
 * Class LogService
 */
trait ApplicationPaths
{
    /**
     * @throws \JsonException
     */
    protected function getApplicationPaths()
    {
        $storagePath = $this->getStoragePath();

        $paths = [
            'application' => $storagePath,
            'equipments' => [
                'images' => 'img/equipments',
                'documents' => 'docs/equipments',
                'diagrams' => 'img/equipments/diagrams',
            ],
            'clients' => [
                'logos' => 'img/clients/logos',
            ],
            'evidences' => [
                'inspections' => 'img/inspections',
            ],
        ];
        return json_decode(json_encode($paths, JSON_THROW_ON_ERROR), false, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * Get the storage path for the application.
     *
     * @return string
     */
    private function getStoragePath(): string
    {
        return '';
    }
}
