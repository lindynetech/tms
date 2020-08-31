<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'web'], function () {

    Route::auth();

    Route::get('/', 'HomeController@index');

    Route::get('/support', 'HomeController@requestSupport');

    /* Goals */
    Route::get('/goals', [
        'middleware' => 'auth',
        'uses' => 'Tms\\GoalController@index'
    ]);
    Route::get('/goals/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\GoalController@listAll'
    ]);
    Route::post('/goals/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\GoalController@edit'
    ]);
    Route::get('/goals/eatfrog', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@viewFrogGoal'
    ]);

    Route::get('/goals/listsingle/{id}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\GoalController@listSingle'
    ]);

    /* Goals / Tasks */
    Route::get('/tasks/view', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@index'
    ]);
    Route::get('/tasks/list/{id}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@listAll'
    ]);
    Route::post('/tasks/edit/{id}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@edit'
    ]);
    /* Goals / SubTasks */
    Route::get('/subtasks/list/{tid}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@listSubtasks'
    ]);
    Route::post('/subtasks/edit/{tid}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\TaskController@editSubtasks'
    ]);

    /* Dailygoals */
    Route::get('/dailygoals', [
        'middleware' => 'auth',
        'uses' => 'Tms\\DailyGoalController@index'
    ]);
    Route::post('/dailygoals/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\DailyGoalController@edit'
    ]);
    Route::get('/dailygoals/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\DailyGoalController@listAll'
    ]);
    Route::get('/dailygoals/flush', [
        'middleware' => 'auth',
        'uses' => 'Tms\\DailyGoalController@flush'
    ]);

    /* Vendors */
    Route::get('/vendors', [
        'middleware' => 'auth',
        'uses' => 'Tms\\VendorController@index'
    ]);
    Route::post('/vendors/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\VendorController@edit'
    ]);
    Route::get('/vendors/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\VendorController@listAll'
    ]);

    /* Mindstorm */
    Route::get('/mindstorm', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@index'
    ]);
    Route::post('/mindstorm/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@edit'
    ]);
    Route::get('/mindstorm/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@listAll'
    ]);
    Route::get('/mindstorm/listideas', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@listIdeas'
    ]);
    Route::get('/mindstorm/listallideas/{id}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@listAllIdeas'
    ]);
    Route::post('/mindstorm/editideas/{id}', [
        'middleware' => 'auth',
        'uses' => 'Tms\\MindstormController@editIdeas'
    ]);

    /* Habits */
    Route::get('/habits', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@index'
    ]);
    Route::get('/habits/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@listAll'
    ]);
    Route::post('/habits/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@edit'
    ]);
    /* Habit */
    Route::get('/habit/gethabitinfo', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@getHabitInfo'
    ]);
    Route::get('/habit/gethabitdays', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@getHabitDays'
    ]);
    Route::get('/habit/populatehabit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@populateHabit'
    ]);
    Route::post('/habit/resethabit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@resetHabit'
    ]);
    Route::post('/habit/savehabit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\HabitController@saveHabit'
    ]);

    /* ReadingList */
    Route::get('/readinglist', [
        'middleware' => 'auth',
        'uses' => 'Tms\\ReadingListController@index'
    ]);
    Route::get('/readinglist/list', [
        'middleware' => 'auth',
        'uses' => 'Tms\\ReadingListController@listAll'
    ]);
    Route::post('/readinglist/edit', [
        'middleware' => 'auth',
        'uses' => 'Tms\\ReadingListController@edit'
    ]);
    Route::get('/readinglist/viewnotes', [
        'middleware' => 'auth',
        'uses' => 'Tms\\ReadingListController@viewNotes'
    ]);
    Route::post('/readinglist/editnotes', [
        'middleware' => 'auth',
        'uses' => 'Tms\\ReadingListController@editNotes'
    ]);

    /* Profile */
    Route::get('/profile', 'Tms\\ProfileController@index');
    Route::post('/profile/store', 'Tms\\ProfileController@store');
    Route::post('/profile/resetpass', 'Tms\\ProfileController@resetPassword');

});
