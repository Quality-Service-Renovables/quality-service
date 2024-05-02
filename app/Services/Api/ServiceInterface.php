<?php

/** @noinspection UnknownInspectionInspection */

/** @noinspection PhpComposerExtensionStubsInspection */

namespace App\Services\Api;

use Illuminate\Http\Request;

interface ServiceInterface
{
    /**
     * Creates a new record in the database based on the given request data and returns an array.
     *
     * @param Request $request The HTTP request object containing the data for creating a new record.
     *
     * @return array The created record data.
     */
    public function create(Request $request): array;

    /**
     * Reads data from the database and returns an array.
     *
     * @return array The data retrieved from the database.
     */
    public function read(): array;

    /**
     * Updates the specified resource in storage.
     *
     * @param Request $request The request object containing the updated data.
     *
     * @return array An array containing the updated resource data.
     */
    public function update(Request $request): array;

    /**
     * Deletes a record from the database based on the given UUID and returns an array.
     *
     * @param string $uuid The UUID of the record to be deleted.
     *
     * @return array The deleted record.
     */
    public function delete(string $uuid): array;

    /**
     * Retrieves and returns the data associated with the given UUID.
     *
     * @param string $uuid The UUID of the data to retrieve.
     *
     * @return array The data associated with the given UUID.
     */
    public function show(string $uuid): array;
}
