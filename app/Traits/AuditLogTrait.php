<?php

namespace App\Traits;

use App\Models\AuditLogs;
use Illuminate\Support\Facades\Auth;

trait AuditLogTrait
{
  /**
   * Add an entry to the audit logs
   *
   * @param string $action
   * @param string|null $details
   * @param int|null $userId
   * @return void
   */
  public function addAuditLog(string $action, ?string $details = null, ?int $userId = null): void
  {
    $userId = $userId ?? Auth::id();

    AuditLogs::create([
      'user_id' => $userId,
      'action' => $action,
      'details' => $details,
      'action_time' => now(),
    ]);
  }
}
