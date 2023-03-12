<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function task_create(Request $request, $project_id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Project::find($project_id);
            if ($project) {
                $product = new Task();
                $product->project_id = $project_id;
                $product->task_name = $request->task_name;
                $product->task_description = $request->task_description;
                $product->task_assigned = $request->task_assigned;
                $product->task_Status = $request->task_Status;
                $product->start_date = $request->start_date;
                $product->end_date = $request->end_date;
                $product->save();

                $data = [
                    'status' => true,
                    'message' => 'Task Successfully Created',
                    'status code' => 201,
                    'data' => $product,
                ];
                return response()->json($data);
            } else {
                $errorMessage = 'Project id does not exist.';
                return response()->json($errorMessage);
            }
        }
    }

    public function all_tasks(Request $request)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $task = Task::all();
            return response()->json([
                $task,
            ]);
        }
    }

    public function search_Task($key)
    {
        return Task::where('task_name', 'Like', "%$key%")->get();
    }

    public function delete_task(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Task::where('id', $id)->delete();
            if ($project) {
                return response()->json([
                    'message' => 'This task is successfull deleted',
                    'status' => true,

                ], 200);
            } else {
                return response()->json([
                    'message' => 'This task is not deleted',
                    'status' => false,
                ], 200);
            }
        }
    }

    public function update_task(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Task::find($id);
            if ($project) {
                $project->task_name = $request->task_name;
                $project->task_description = $request->task_description;
                $project->task_assigned = $request->task_assigned;
                $project->task_Status = $request->task_Status;
                $project->start_date = $request->start_date;
                $project->end_date = $request->end_date;
                $project->save();
                return response()->json([
                    'message' => 'This task is successfully Updated',
                    'status' => true,

                ], 200);
            } else {
                return response()->json([
                    'message' => 'This task Update failed!Not Found this task id',
                    'status' => 'failed'
                ], 404);
            }
        }
    }

    public function task_with_specific_project(Request $request, $project_id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Task::find($project_id)->Project;
            return $project;
        }
    }
}
