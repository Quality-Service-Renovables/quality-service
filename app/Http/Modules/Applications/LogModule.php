<?php
/**
 * Log Module.
 *
 * Register global activities
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

namespace App\Http\Modules\Applications;

use App\Models\Application\Log;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class LogModule
 */
class LogModule
{
    /**
     * @var bool Indicates whether the data has been successfully saved.
     */
    public bool $isSaved;

    /**
     * @var string Holds the custom message for the application.
     */
    public string $message;

    /**
     * Create a new instance of the class.
     *
     * @return void
     */
    public function __construct()
    {
        $this->isSaved = false;
        $this->message = '';
    }

    public function create(string $module, array $request, array $response = [], string $description = '', $user = null): void
    {
        try {
            DB::beginTransaction();

            $user = $user ?? auth()->id();

            Log::create([
                'application_log_uuid' => Str::uuid()->toString(),
                'request_url' => url()->current(),
                'request_received' => json_encode($request, JSON_THROW_ON_ERROR),
                'request_response' => json_encode($response, JSON_THROW_ON_ERROR),
                'module' => $module,
                'description' => $description,
                'user_id' => $user,
            ]);

            $this->isSaved = true;

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            $this->isSaved = false;
            $this->message = $exception->getMessage();
        }
    }
}
