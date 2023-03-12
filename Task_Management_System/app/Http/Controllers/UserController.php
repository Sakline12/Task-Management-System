<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function project_are(Request $request)
    {
        $user = $request->user();
        $lastName = $user->last_name;
        if ($user->type == "User" && !empty($lastName)) {
            $project = Project::where('project_assigned', $lastName)->get();
            if ($project) {
                return response()->json([
                    'project_assigned' => $project
                ]);
            } else {
                return response()->json([
                    'error' => 'Project not found for this user'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'User not found or invalid user type'
            ]);
        }
    }

    public function project_update(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "User") {
            $data = Project::find($id);
            $data->project_Status = $request->project_Status;
            $data->save();
            return response()->json(
                "Status Update Sucessfully"
            );
        } else {
            return response()->json([
                "User Not found"
            ]);
        }
    }

    public function task_are(Request $request)
    {
        $user = $request->user();
        $lastName = $user->last_name;
        if ($user->type == "User" && !empty($lastName)) {
            $task = Task::where('task_assigned', $lastName)->get();
            if ($task) {
                return response()->json([
                    'project_assigned' => $task
                ]);
            } else {
                return response()->json([
                    'error' => 'Task not found for this user'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'User not found or invalid user type'
            ]);
        }
    }

    public function task_update(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "User") {
            $data = Task::find($id);
            $data->task_Status = $request->task_Status;
            $data->save();
            return response()->json(
                "Status Update Sucessfully"
            );
        } else {
            return response()->json([
                "User Not found"
            ]);
        }
    }
}
