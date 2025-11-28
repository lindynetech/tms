<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
});
*/
/* Public Routes */

Route::get('/', 'LandingController@index');
Route::post('/contact', 'LandingController@contact');
Route::get('/privacypolicy', 'LandingController@privacypolicy');

/* Members Area */
// Auth::routes(['verify' => true]);
// Route::auth(); // Removed in Laravel 12 - replaced with manual routes below

// Authentication Routes
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('logout', [LoginController::class, 'logout'])->name('logout.get'); // Added GET method for logout links

// Registration Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['middleware' => ['auth']], function () {
// Note: 'paid' and 'verified' middleware removed - add custom middleware if needed

Route::get('/app', 'HomeController@index');

/* Goals */
Route::get('/goals', [
    'uses' => 'Tms\\GoalController@index'
]);
Route::get('/goals/list', [
    'uses' => 'Tms\\GoalController@listAll'
]);
Route::post('/goals/edit', [
    'uses' => 'Tms\\GoalController@edit'
]);
Route::get('/goals/eatfrog', [
    'uses' => 'Tms\\TaskController@viewFrogGoal'
]);

Route::get('/goals/listsingle/{id}', [
    'uses' => 'Tms\\GoalController@listSingle'
]);

/* Goals / Tasks */
Route::get('/tasks/view', [
    'uses' => 'Tms\\TaskController@index'
]);
Route::get('/tasks/list/{id}', [
    'uses' => 'Tms\\TaskController@listAll'
]);
Route::post('/tasks/edit/{id}', [
    'uses' => 'Tms\\TaskController@edit'
]);
/* Goals / SubTasks */
Route::get('/subtasks/list/{tid}', [
    'uses' => 'Tms\\TaskController@listSubtasks'
]);
Route::post('/subtasks/edit/{tid}', [
    'uses' => 'Tms\\TaskController@editSubtasks'
]);

/* Dailygoals */
Route::get('/dailygoals', [
    'uses' => 'Tms\\DailyGoalController@index'
]);
Route::post('/dailygoals/edit', [
    'uses' => 'Tms\\DailyGoalController@edit'
]);
Route::get('/dailygoals/list', [
    'uses' => 'Tms\\DailyGoalController@listAll'
]);
Route::get('/dailygoals/flush', [
    'uses' => 'Tms\\DailyGoalController@flush'
]);

/* Vendors */
Route::get('/vendors', [
    'uses' => 'Tms\\VendorController@index'
]);
Route::post('/vendors/edit', [
    'uses' => 'Tms\\VendorController@edit'
]);
Route::get('/vendors/list', [
    'uses' => 'Tms\\VendorController@listAll'
]);

/* Mindstorm */
Route::get('/mindstorm', [
    'uses' => 'Tms\\MindstormController@index'
]);
Route::post('/mindstorm/edit', [
    'uses' => 'Tms\\MindstormController@edit'
]);
Route::get('/mindstorm/list', [
    'uses' => 'Tms\\MindstormController@listAll'
]);
Route::get('/mindstorm/listideas', [
    'uses' => 'Tms\\MindstormController@listIdeas'
]);
Route::get('/mindstorm/listallideas/{id}', [
    'uses' => 'Tms\\MindstormController@listAllIdeas'
]);
Route::post('/mindstorm/editideas/{id}', [
    'uses' => 'Tms\\MindstormController@editIdeas'
]);

/* Habits */
Route::get('/habits', [
    'uses' => 'Tms\\HabitController@index'
]);
Route::get('/habits/list', [
    'uses' => 'Tms\\HabitController@listAll'
]);
Route::post('/habits/edit', [
    'uses' => 'Tms\\HabitController@edit'
]);
/* Habit */
Route::get('/habit/gethabitinfo', [
    'uses' => 'Tms\\HabitController@getHabitInfo'
]);
Route::get('/habit/gethabitdays', [
    'uses' => 'Tms\\HabitController@getHabitDays'
]);
Route::get('/habit/populatehabit', [
    'uses' => 'Tms\\HabitController@populateHabit'
]);
Route::post('/habit/resethabit', [
    'uses' => 'Tms\\HabitController@resetHabit'
]);
Route::post('/habit/savehabit', [
    'uses' => 'Tms\\HabitController@saveHabit'
]);

/* ReadingList */
Route::get('/readinglist', [
    'uses' => 'Tms\\ReadingListController@index'
]);
Route::get('/readinglist/list', [
    'uses' => 'Tms\\ReadingListController@listAll'
]);
Route::post('/readinglist/edit', [
    'uses' => 'Tms\\ReadingListController@edit'
]);
Route::get('/readinglist/viewnotes', [
    'uses' => 'Tms\\ReadingListController@viewNotes'
]);
Route::post('/readinglist/editnotes', [
    'uses' => 'Tms\\ReadingListController@editNotes'
]);

});

Route::get('/support', 'HomeController@requestSupport');
Route::get('/help', 'HomeController@help');



/* Profile */
Route::get('/profile', 'Tms\\ProfileController@index');
Route::post('/profile/store', 'Tms\\ProfileController@store');
Route::post('/profile/resetpass', 'Tms\\ProfileController@resetPassword');


// Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout'); // Already defined above

/*Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/