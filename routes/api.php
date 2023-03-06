<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoleMenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("siteverify", [AuthController::class, "verify"]);
Route::post("login", [AuthController::class, "login"]);

Route::middleware('auth:sanctum')
    ->group(function () {
        Route::prefix('auth')
            ->group(function () {
                Route::prefix('v1')
                    ->controller(AuthController::class)
                    ->group(function () {
                        Route::post('user', 'index');
                        Route::post('register', 'register');
                        Route::post('update', 'update');
                        Route::post('change-password', 'change_password');
                    });
            });

        Route::prefix('setup-aplikasi')
            ->group(function () {
                Route::prefix('v1')
                    ->group(function () {
                        Route::controller(ModuleController::class)
                            ->group(function () {
                                Route::get('module', 'index');
                                Route::post('store-module', 'store');
                                Route::get('show-module/{id}', 'show');
                                Route::put('update-module/{id}', 'update');
                                Route::delete('destroy-module/{id}', 'destroy');
                            });

                        Route::controller(MenuController::class)
                            ->group(function () {
                                Route::get('menu', 'index');
                                Route::post('store-menu', 'store');
                                Route::get('show-menu/{menu}', 'show');
                                Route::put('update-menu/{menu}', 'update');
                                Route::delete('destroy-menu/{menu}', 'destroy');
                            });

                        Route::controller(RoleController::class)
                            ->group(function () {
                                Route::get('role', 'index');
                                Route::post('store-role', 'store');
                                Route::get('show-role/{role}', 'show');
                                Route::put('update-role/{role}', 'update');
                                Route::delete('destroy-role/{role}', 'destroy');
                            });

                        Route::controller(RoleMenuController::class)
                            ->group(function () {
                                Route::get('role-menu', 'index');
                                Route::post('list-menu', 'list_menu');
                                Route::post('store-role-menu', 'store');
                                Route::get('show-role-menu/{roleMenu}', 'show');
                                Route::put('update-role-menu/{roleMenu}', 'update');
                                Route::delete('destroy-role-menu/{roleMenu}', 'destroy');
                            });

                        Route::controller(UserRoleController::class)
                            ->group(function () {
                                Route::get('user-role', 'index');
                                Route::get('list-role', 'list_role');
                                Route::post('store-user-role', 'store');
                                Route::get('show-user-role/{userRole}', 'show');
                                Route::put('update-user-role/{userRole}', 'update');
                                Route::delete('destroy-user-role/{userRole}', 'destroy');
                            });

                        Route::controller(NavigationController::class)
                            ->group(function () {
                                Route::get('navigation', 'index');
                            });

                        Route::controller(UserController::class)
                            ->group(function () {
                                Route::get('user', 'index');
                                Route::post('store-user', 'store');
                                Route::get('show-user/{user}', 'show');
                                Route::put('update-user/{user}', 'update');
                                Route::delete('destroy-user/{user}', 'destroy');
                            });
                    });
            });
    });
