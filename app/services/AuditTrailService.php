<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditTrailService
{
    /**
     * Simpan audit log
     */
    public static function log(
        string $action,
        string $table,
        $rowId = null,
        string $message = null,
        $before = null,
        $after = null
    ): void {
        AuditLog::create([
            'occurred_at' => now(),
            'user_id'     => Auth::id(),
            'user_name'   => Auth::user()->name ?? 'SYSTEM',
            'action'      => $action,
            'table_name'  => $table,
            'row_id'      => $rowId,
            'message'     => $message,
            'before_data' => $before,
            'after_data'  => $after,
            'url'         => Request::fullUrl(),
            'ip_address'  => Request::ip(),
            'http_method' => Request::method(),
            'created_at'  => now(),
        ]);
    }


    /**
     * Helper cepat untuk CREATE
     */
    public static function created(
        string $tableName,
        int $rowId,
        array $after,
        ?string $message = null
    ): void {
        self::log(
            'CREATE',
            $tableName,
            $rowId,
            null,
            $after,
            $message
        );
    }

    /**
     * Helper cepat untuk UPDATE
     */
    public static function updated(
        string $tableName,
        int $rowId,
        array $before,
        array $after,
        ?string $message = null
    ): void {
        self::log(
            'UPDATE',
            $tableName,
            $rowId,
            $before,
            $after,
            $message
        );
    }

    /**
     * Helper cepat untuk DELETE
     */
    public static function deleted(
        string $tableName,
        int $rowId,
        array $before,
        ?string $message = null
    ): void {
        self::log(
            'DELETE',
            $tableName,
            $rowId,
            $before,
            null,
            $message
        );
    }

    /**
     * Helper untuk ACTION KHUSUS
     * (FINAL_OPNAME, DISPOSAL, LOGIN, dll)
     */
    public static function action(
        string $action,
        string $tableName,
        ?int $rowId = null,
        ?array $before = null,
        ?array $after = null,
        ?string $message = null
    ): void {
        self::log(
            $action,
            $tableName,
            $rowId,
            $before,
            $after,
            $message
        );
    }
}
