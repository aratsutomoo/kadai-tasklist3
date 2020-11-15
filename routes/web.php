<?php
// デフォルトのコメント部分は省略
//Route::get('tasks/', 'TasksController@index');
//Route::resource('tasks', 'TasksController');

Route::get('/', 'TasksController@index');
Route::resource('tasks', 'TasksController');
