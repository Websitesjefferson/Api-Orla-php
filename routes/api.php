<?php

use Illuminate\Http\Request;

// Rota para buscar todos os projetos
Route::get('/projects', 'ProjectController@index');

// Rota para criar um novo projeto
Route::post('/projects', 'ProjectController@store');

// Rota para buscar um projeto específico por ID
Route::get('/projects/{project}', 'ProjectController@show');

// Rota para atualizar um projeto existente
Route::put('/projects/update', 'ProjectController@update');

// Rota para excluir um projeto por ID
Route::delete('/projects/{id}', 'ProjectController@destroy');

// Rotas para funcionários

// Rota para buscar todos os funcionários
Route::get('/employees', 'EmployeesController@index');

// Rota para criar um novo funcionário
Route::post('/employees', 'EmployeesController@store');

// Rota para atualizar um funcionário existente
Route::put('/employees/update', 'EmployeesController@update');

// Rota para excluir um funcionário por ID
Route::delete('/employees/{id}', 'EmployeesController@destroy');

// Rota para buscar funcionários por projeto usando o ID do projeto
Route::get('/employees/project/{projectId}', 'EmployeesController@getEmployeesByProject');

// Rota para adicionar um funcionário a um projeto específico
Route::post('/projects/{project}/addEmployee', 'ProjectController@addEmployee');

