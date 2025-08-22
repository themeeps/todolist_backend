<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Task;

class OwnerOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $task = $request->route('task'); // ini sudah Task instance

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        if (
            $user->role === 'admin' ||
            $task->owner_id === $user->id ||
            $task->assigned_to === $user->id
        ) {
            return $next($request);
        }

        return response()->json(['message' => 'Forbidden. Only owner or admin can perform this action.'], 403);
    }
}
