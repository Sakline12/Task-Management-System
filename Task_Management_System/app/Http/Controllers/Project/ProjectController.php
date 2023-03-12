<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function project(Request $request)
    {
        $id = $request->user()->id;
        $user = $request->user();

        if ($user && $user->type == "Admin") {
            $project = new Project();
            $project->user_id = $id;
            $project->project_name = $request->project_name;
            $project->project_description = $request->project_description;
            $project->project_assigned = $request->project_assigned;
            $project->project_Status = $request->project_Status;
            $project->start_date = $request->start_date;
            $project->end_date = $request->end_date;
            $project->save();

            $data = [
                'status' => true,
                'message' => 'Project Successfully Created',
                'status code' => 201,
                'data' => $project,
            ];

            return response()->json($data);
        } else {
            $errorMessage = 'User id does not exist or user is not an admin.';
            return response()->json($errorMessage, 500);
        }
    }

    public function all_projects(Request $request)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Project::all();
            return response()->json([
                $project,
            ]);
        }
    }

    public function delete_project(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Project::where('id', $id)->delete();
            if ($project) {
                return response()->json([
                    'message' => 'This Project is successfull deleted',
                    'status' => true,

                ], 200);
            } else {
                return response()->json([
                    'message' => 'This Project is not deleted',
                    'status' => false,
                ], 200);
            }
        }
    }

    public function searchProject($key)
    {
        return Project::where('project_name', 'Like', "%$key%")->get();
    }

    public function update_project(Request $request, $id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Project::find($id);
            if ($project) {
                $project->project_name = $request->project_name;
                $project->project_description = $request->project_description;
                $project->project_assigned = $request->project_assigned;
                $project->project_Status = $request->project_Status;
                $project->start_date = $request->start_date;
                $project->end_date = $request->end_date;
                $project->save();
                return response()->json([
                    'message' => 'This Project successfull Updated',
                    'status' => true,

                ], 200);
            } else {
                return response()->json([
                    'message' => 'This Project Update failed!Not Found this project',
                    'status' => 'failed'
                ], 404);
            }
        }
    }

    public function project_with_specific_user(Request $request, $user_id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $project = Project::find($user_id)->User;
            return $project;
        }
    }


}
