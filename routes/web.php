<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\WelcomepageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SkillsController;

use App\Http\Controllers\ProjectRequestController;

// Home page
Route::get('/', [Authentication::class, 'welcome']);

// Register page navigation
Route::get('/navregister', [Authentication::class, 'navregister']);

// User login
Route::post('/login', [Authentication::class, 'loginUser']);

// Login page navigation
Route::get('/navlogin', [Authentication::class, 'navLogin']);

// Registration step 1 (personal details)
Route::post('/register', [Authentication::class, 'register']);

// Registration step 2
Route::post('/step_two', [Authentication::class, 'step_two_register']);

// Dashboard page (protected or after login)
Route::get('/dashboard', [Authentication::class, 'dashboard'])->name('dashboard');

// Logout
Route::post('/logout', [Authentication::class, 'logout']);

// Team page
Route::get('/team', [TeamController::class, 'index'])->name('team');

// Projects page
Route::get('/projects', [ProjectController::class, 'index'])->name('projects');

Route::get("/navcreateproject",[ProjectController::class,'navcreateproject'])->name('navCreateProject');

Route::post('/CreateProject',[ProjectController::class,'CreateProject']);

Route::get('/view/{project}',[ProjectController::class,'viewProject'])->name('viewProject');

Route::post('/deleteProject',[ProjectController::class,'deleteProject'])->name('deleteProject');

//MY project
Route::get('/navMyProject',[ProjectController::class,'navMyProject'])->name('navMyProject');

// Tasks page
// Route::get('/tasks', [TaskController::class, 'index'])->name('tasks');

// Messages page
Route::get('/messages', [MessageController::class, 'index'])->name('messages');
// Route::get('/messages', [MessageController::class, 'index'])->name('messages');


// Meetings page
Route::get('/meetings', [MeetingController::class, 'index'])->name('meetings');

// Settings page
Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

Route::get('/how-it-works', [WelcomePageController::class, 'howItWorks'])->name('how-it-works');

Route::get('/Home', [WelcomepageController::class, 'home'])->name('home');

Route::get('/explore-projects', [WelcomepageController::class, 'exploreProjects'])->name('explore-projects');

Route::get('/find-talent', [WelcomepageController::class, 'findTalent'])->name('find-talent');

Route::get('/help', [WelcomepageController::class, 'help'])->name('help');

Route::get('/profile/{id}',[UsersController::class, 'profile']);

Route::get('/navUsers',[UsersController::class,'navUsers'])->name('navUsers');

Route::get('/verify', [Authentication::class, 'verify']);

Route::get('/navProfile/edit',[UsersController::class, 'navedit']);

Route::post('/profile/update',[UsersController::class, 'profileUpdate']);

Route::get('/profession/search',[SkillsController::class,'getProfession']);

Route::get('/skills/search',[SkillsController::class,'getSkills']);

Route::get('/interests/search',[SkillsController::class,'getInterests']);

Route::get('/softSkill/search',[SkillsController::class,'getSoftskills']);

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', \App\Http\Controllers\TaskController::class)->except(['show']);
    Route::get('tasks/{task}', [\App\Http\Controllers\TaskController::class, 'show'])->name('tasks.show');
});


    Route::middleware(['auth'])->group(function () {
    // List tasks
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    
    // Create task
    Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('tasks', [TaskController::class, 'store'])->name('tasks.store');
    
    // View single task
    Route::get('tasks/{task}', [TaskController::class, 'show'])
        ->name('tasks.show')
        ->middleware('can:view,task');
    
    // Edit task
    Route::get('tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('tasks.edit')
        ->middleware('can:update,task');
    Route::put('tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
    Route::patch('tasks/{task}', [TaskController::class, 'update']);
    
    // Delete task
    Route::delete('tasks/{task}', [TaskController::class, 'destroy'])
        ->name('tasks.destroy')
        ->middleware('can:delete,task');
});

// Make sure you have routes defined like this:
Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

Route::get('tasks/create', [TaskController::class, 'create'])->name('tasks.create');

Route::get('/navUpdateProject/{id}',[ProjectController::class,'navUpdateProject'])->name('editProject');

Route::post('/UpdateProject/{id}',[ProjectController::class,'UpdateProject']);

Route::get('/project/request/{requesterId}/accept', [ProjectRequestController::class, 'acceptRequest']);

Route::get('/project/request/{requester}/reject', [ProjectRequestController::class, 'rejectRequest'])->name('project.reject');

Route::post('/request/{project}', [ProjectRequestController::class, 'sendRequest'])->name('request');

Route::post('/projects/{project}/invite', [ProjectRequestController::class, 'sendInvite'])->name('sendInvite');





