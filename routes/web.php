<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OffdayController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\SearchController;


Route::get('/', function () {
    return view('auth.login');
});




Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::post('/admin/users', [AdminController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
    Route::get('/admin/users/show', [UserController::class, 'show'])->name('admin.users.show');
    Route::get('/admin/users/assaign', [UserController::class, 'assaign'])->name('admin.users.assaign');
    Route::get('/admin/users/index', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
    Route::post('/admin/tasks', [AdminController::class, 'storeTask'])->name('admin.tasks.store');
    Route::get('/admin/work-sessions', [AdminController::class, 'showWorkSessions'])->name('admin.workSessions');
    Route::get('/admin/work-sessions/{id}/edit', [AdminController::class, 'editWorkSession'])->name('admin.editWorkSession');
    Route::post('/admin/work-sessions/{id}', [AdminController::class, 'updateWorkSession'])->name('admin.updateWorkSession');
    Route::delete('/admin/work-sessions/{id}', [AdminController::class, 'destroyWorkSession'])->name('admin.destroyWorkSession');
    Route::get('/admin/filter-work-sessions', [AdminController::class, 'filterWorkSessions'])->name('admin.filterWorkSessions');
    Route::get('/admin/offdays', [OffdayController::class, 'index'])->name('admin.offdays.index');
    Route::post('/admin/offdays/{id}/approve', [OffdayController::class, 'approve'])->name('admin.offdays.approve');
    Route::post('/admin/offdays/{id}/reject', [OffdayController::class, 'reject'])->name('admin.offdays.reject');
    Route::get('/admin/offdays/{id}/edit', [OffdayController::class, 'edit'])->name('admin.offdays.edit');
    Route::put('/admin/offdays/{id}', [OffdayController::class, 'update'])->name('admin.offdays.update');
    Route::delete('/admin/offdays/{id}', [OffdayController::class, 'destroy'])->name('admin.offdays.destroy');

    Route::get('/admin/reports/index', [ReportController::class, 'index'])->name('admin.reports.index');





    






});

Route::middleware('auth')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');
    Route::get('/user', [UserController::class, 'showUserTasks'])->name('user');

    Route::get('/manager', [UserController::class, 'showUserTasks1'])->name('manager');


    Route::get('/profile', [UserController::class, 'showProfile'])->name('profile');




    Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');





    Route::get('/userProfile', [UserController::class, 'showProfile1'])->name('userProfile');




    Route::post('/user/start-work-session', [UserController::class, 'startWorkSession'])->name('user.startWorkSession');
    Route::post('/user/start-break', [UserController::class, 'startBreak'])->name('user.startBreak');
    Route::post('/user/end-break', [UserController::class, 'endBreak'])->name('user.endBreak');
    Route::post('/user/end-work-session', [UserController::class, 'endWorkSession'])->name('user.endWorkSession');
    Route::get('/user/work-sessions', [UserController::class, 'showWorkSessions'])->name('user.workSessions');

    Route::get('/offday/index', [OffdayController::class, 'indexUser'])->name('offday.index');
    Route::get('/offday/create', [OffdayController::class, 'createUser'])->name('offday.create');
    Route::post('/offday', [OffdayController::class, 'storeUser'])->name('offday.store');
    Route::get('/offdays/{id}', [OffdayController::class, 'show'])->name('offdays.show');
    Route::put('/offdays/{id}', [OffdayController::class, 'update'])->name('offdays.update');
});

Route::resource('projects', ProjectController::class);
Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::get('/users/{id}/tasks', [UserController::class, 'showTasks'])->name('admin.index');
Route::get('/tasks/index', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/chart-data', [AdminController::class, 'getChartData'])->name('tasks.chart-data');
Route::post('/tasks/{id}/update-status', [AdminController::class, 'updateTaskStatus'])->name('tasks.update-status');

Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/navbar-tasks', [TaskController::class, 'index1'])->name('navbar.tasks');

Route::get('/tasks/{task}/attachments', [TaskController::class, 'getAttachments']);


Route::get('/admin/users/search1', [UserController::class, 'search1'])->name('admin.users.search1');



Route::get('/tasks/status-counts', [TaskController::class, 'getStatusCounts']);
Route::get('/tasks', [TaskController::class, 'index']);





Route::get('/mission', [TaskController::class, 'index1'])->name('mission.index');
Route::get('/mission/{id}/edit', [TaskController::class, 'edit'])->name('mission.edit');
Route::patch('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy');
Route::get('/navbar-tasks', [TaskController::class, 'index1'])->name('navbar.tasks');




Route::get('/offday/monthly-data', [OffdayController::class, 'getMonthlyOffdayData']);



Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/admin/users/search', [UserController::class, 'search']);

Route::get('/search', [SearchController::class, 'search']);


Route::get('/admin/users/search', [UserController::class, 'search']);
Route::get('/admin/users/show/{id}', [UserController::class, 'show1']);
Route::get('/mission/index', [TaskController::class, 'index1']);
Route::get('/projects/index', [ProjectController::class, 'show']);


Route::get('/tasks/{id}', [TaskController::class, 'show'])->name('tasks.show');


Route::get('/attachments/download/{filename}', [AttachmentController::class, 'download'])->name('attachments.download');

Route::get('/attachments/{filename}', [AttachmentController::class, 'download'])->name('attachments.downloads');


Route::get('/missions', [TaskController::class, 'filter'])->name('mission.index');


Route::get('/admin/users/search2', [OffdayController::class, 'search2'])->name('admin.users.search2');

Route::get('/admin/users/search3', [OffdayController::class, 'search3'])->name('admin.users.search3');




Route::get('user/projects', [ProjectController::class, 'index1'])->name('user.projects.index');



Route::get('user/projects/{id}', [ProjectController::class, 'show1'])->name('user.projects.show');


Route::get('/projects/index', [ProjectController::class, 'show']);



Route::get('/mission/user', [TaskController::class, 'index2']);

Route::get('/mission/user', [TaskController::class, 'index2'])->name('mission.indexUser');


Route::get('/missions/user', [TaskController::class, 'filter1'])->name('mission.index1');


Route::get('/user/worksessions', [AdminController::class, 'showWorkSessions1'])->name('user.worksessions');


Route::get('/user/teammates', [UserController::class, 'show2'])->name('user.teammates');



Route::get('/user/contact', [UserController::class, 'show3'])->name('user.contact');



Route::post('/contact', [UserController::class, 'storeContact'])->name('contact.store');


Route::get('/admin/contacts', [AdminController::class, 'contactindex'])->name('admin.contacts.index');

Route::get('/admin/contacts/{id}', [AdminController::class, 'contactshow'])->name('admin.contacts.show');


Route::get('/admin/users/search9', [UserController::class, 'search9'])->name('admin.users.search9');



Route::delete('/admin/contacts/{id}', [TaskController::class, 'contactdestroy'])->name('contact.destroy');

Route::patch('/tasks/{task}/archive', [TaskController::class, 'archive'])->name('tasks.archive');

Route::patch('/tasks/{task}/restore', [TaskController::class, 'restore'])->name('tasks.restore');


Route::patch('/tasks/{id}/update-status', [TaskController::class, 'updateStatus']);


use App\Http\Controllers\WaitingController;

Route::get('/tasks/waiting/{id}', [WaitingController::class, 'index'])->name('tasks.waiting');
Route::post('/tasks/waiting/{id}', [WaitingController::class, 'store'])->name('tasks.waiting.upload');
Route::get('/tasks/waiting/download/{id}', [WaitingController::class, 'download'])->name('tasks.waiting.download');
Route::delete('/tasks/waiting/delete/{id}', [WaitingController::class, 'destroy'])->name('tasks.waiting.delete');


use App\Http\Controllers\ApprovedController;

Route::get('/tasks/approved/{id}', [ApprovedController::class, 'index'])->name('tasks.approved');
Route::post('/tasks/approved/{id}', [ApprovedController::class, 'store'])->name('tasks.approved.upload');
Route::get('/tasks/approved/download/{id}', [ApprovedController::class, 'download'])->name('tasks.approved.download');
Route::delete('/tasks/approved/delete/{id}', [ApprovedController::class, 'destroy'])->name('tasks.approved.delete');


use App\Http\Controllers\RevisedController;

Route::get('/tasks/revised/{id}', [RevisedController::class, 'index'])->name('tasks.revised');
Route::post('/tasks/revised/{id}', [RevisedController::class, 'store'])->name('tasks.revised.upload');
Route::get('/tasks/revised/download/{id}', [RevisedController::class, 'download'])->name('tasks.revised.download');
Route::delete('/tasks/revised/delete/{id}', [RevisedController::class, 'destroy'])->name('tasks.revised.delete');


Route::get('/admin/projects/{id}/get-manager', [ProjectController::class, 'getManager']);
Route::get('/admin/projects/{id}/users/assign', [ProjectController::class, 'getProjectUsers']);



use App\Http\Controllers\ProjectFilesController;

Route::get('/projects/files/{projectId}', [ProjectFilesController::class, 'show']);
Route::delete('/projects/files/delete/{fileId}', [ProjectFilesController::class, 'destroy']);
