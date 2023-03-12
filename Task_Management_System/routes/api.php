<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Project\ProjectController;
use App\Http\Controllers\Task\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'registration']);
Route::post('login', [AuthController::class, 'login']);


// Route::post('forgot_password')


Route::group(['middleware' => ['auth:sanctum']], function () {

    ///for project
    Route::post('project_create', [ProjectController::class, 'project']);
    Route::get('all_projects', [ProjectController::class, 'all_projects']);
    Route::delete('delete_project/{id}', [ProjectController::class, 'delete_project']);
    Route::get('searchProject/{key}', [ProjectController::class, 'searchProject']);
    Route::post('update_project/{id}', [ProjectController::class, 'update_project']);
    Route::get('project_specific_user/{user_id}', [ProjectController::class, 'project_with_specific_user']);


    ///for task
    Route::post('task_create/{id}', [TaskController::class, 'task_create']);
    Route::get('all_tasks', [TaskController::class, 'all_tasks']);
    Route::get('search_Task/{key}', [TaskController::class, 'search_Task']);
    Route::delete('delete_task/{id}', [TaskController::class, 'delete_task']);
    Route::post('update_task/{id}', [TaskController::class, 'update_task']);
    Route::get('task_with_specific_project/{id}', [TaskController::class, 'task_with_specific_project']);


    ///for user
    Route::post('profile_update', [ProfileController::class, 'profile_update']);
    Route::get('project_are', [UserController::class, 'project_are']);
    Route::post('project_status_update/{id}', [UserController::class, 'project_update']);
    Route::get('task_are', [UserController::class, 'task_are']);
    Route::post('task_status_update/{id}', [UserController::class, 'task_update']);


    ///for comment

    Route::post('create_comment/{task_id}', [CommentController::class, 'create_comment']);
    Route::get('comment_with_task/{task_id}', [CommentController::class, 'comment_with_task']);

    Route::post('logout', [AuthController::class, 'logout']);


});
Route::post('forgot_password',[NewPasswordController::class,'forgotPassword']);
Route::post('reset_password',[NewPasswordController::class,'reset']);
