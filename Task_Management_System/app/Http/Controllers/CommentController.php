<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function create_comment(Request $request, $task_id)
    {
        $user = $request->user();
        if ($user->type == "Admin") {
            $comment = Task::find($task_id);
            if ($comment) {
                $product = new Comment();
                $product->task_id = $task_id;
                $product->comment_box = $request->comment_box;
                $product->save();

                $data = [
                    'status' => true,
                    'message' => 'Comment Successfully Created',
                    'status code' => 201,
                    'data' => $product,
                ];
                return response()->json($data);
            } else {
                $errorMessage = 'Task id does not exist.';
                return response()->json($errorMessage);
            }
        }
    }

    public function comment_with_task(Request $request, $task_id)
    {
        $user = $request->user();
        if ($user->type == "User") {
            $task = Comment::find($task_id)->task;
            return $task;
        } else {
            return response()->json([
                "Task id not found",
            ]);
        }
    }
}
