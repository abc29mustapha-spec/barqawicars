<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    // Consultation du journal d'audit (lecture seule)
    public function index(Request $request)
    {
        // Seuls les admins voient les logs
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs.');
        }

        $query = AuditLog::with('user');

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('entity_type')) {
            $query->where('entity_type', $request->entity_type);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $logs = $query->latest('created_at')->paginate(50)->withQueryString();

        return view('admin.audit-logs.index', compact('logs'));
    }
}
