<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;

class TaskAssignmentController extends Controller
{
    public function assign(Request $request, Task $task)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $task->assigned_to = $request->assigned_to;
        $task->save();

        return response()->json($task);
    }
}
