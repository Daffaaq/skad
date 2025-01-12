<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\kelasdantingkatController;
use App\Http\Controllers\MatapelajaranController;
use App\Http\Controllers\Menu\MenuGroupController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\RoleAndPermission\AssignPermissionController;
use App\Http\Controllers\RoleAndPermission\AssignUserToRoleController;
use App\Http\Controllers\RoleAndPermission\ExportPermissionController;
use App\Http\Controllers\RoleAndPermission\ExportRoleController;
use App\Http\Controllers\RoleAndPermission\ImportPermissionController;
use App\Http\Controllers\RoleAndPermission\ImportRoleController;
use App\Http\Controllers\RoleAndPermission\PermissionController;
use App\Http\Controllers\RoleAndPermission\RoleController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaToKelasController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Models\Category;
use App\Models\kelas;

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

Route::get('/', function () {
    return view('auth/login');
});

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('home', ['users' => User::get(),]);
    });

    Route::get('/active-periode', [PeriodeController::class, 'getActivePeriode']);

    // master
    Route::group(['prefix' => 'master-management'], function () {
        // periode
        Route::resource('periode', PeriodeController::class);
        Route::post('import/periode', [PeriodeController::class, 'import'])->name('periode.import');
        Route::get('export/periode', [PeriodeController::class, 'export'])->name('periode.export');

        //Mata Pelajaran
        Route::resource('mata-pelajaran', MatapelajaranController::class);
        Route::post('import/mata-pelajaran', [MatapelajaranController::class, 'import'])->name('mata-pelajaran.import');
        Route::get('export/mata-pelajaran', [MatapelajaranController::class, 'export'])->name('mata-pelajaran.export');

        //tingkat kelas
        Route::resource('tingkat-kelas', kelasdantingkatController::class);
        Route::get('tingkat-kelas/show-kelas/{id}', [kelasdantingkatController::class, 'showkelas'])->name('tingkat-kelas.show-kelas');
        Route::get('tingkat-kelas/create-kelas/{id}', [kelasdantingkatController::class, 'indexTambahKelas'])->name('tingkat-kelas.create-kelas');
        Route::post('tingkat-kelas/create-kelas/{id}', [kelasdantingkatController::class, 'tambahkelas'])->name('tingkat-kelas.create-kelas-store');
        Route::delete('tingkat-kelas/destroy-kelas/{id}', [kelasdantingkatController::class, 'deleteKelas'])->name('tingkat-kelas.destroy-kelas');

        //guru
        Route::resource('guru', GuruController::class);
        Route::post('guru/import', [GuruController::class, 'import'])->name('guru.import');

        //siswa
        Route::resource('siswa', SiswaController::class);
        Route::post('/siswa/import', [SiswaController::class, 'importSiswa'])->name('siswa.import');
    });

    // akademik management
    Route::group(['prefix' => 'akademik-management'], function () {
        // siswa to kelas
        Route::resource('siswa-kelas', SiswaToKelasController::class);
        Route::get('/kelas-by-tingkat/{tingkat_id}', [SiswaToKelasController::class, 'getKelasByTingkat']);
        Route::post('/siswa-kelas/auto-assign/', [SiswaToKelasController::class, 'randomAssign'])->name('siswa-kelas.autoAssign');
        Route::get('/siswa-kelas/auto-assign/store', [SiswaToKelasController::class, 'createRandomKelas'])->name('siswa-kelas.random');
    });

    //user list
    Route::prefix('user-management')->group(function () {
        Route::resource('user', UserController::class);
        Route::post('import', [UserController::class, 'import'])->name('user.import');
        Route::get('export', [UserController::class, 'export'])->name('user.export');
        Route::get('demo', DemoController::class)->name('user.demo');
    });

    Route::prefix('menu-management')->group(function () {
        Route::resource('menu-group', MenuGroupController::class);
        Route::resource('menu-item', MenuItemController::class);
    });
    Route::group(['prefix' => 'role-and-permission'], function () {
        //role
        Route::resource('role', RoleController::class);
        Route::get('role/export', ExportRoleController::class)->name('role.export');
        Route::post('role/import', ImportRoleController::class)->name('role.import');

        //permission
        Route::resource('permission', PermissionController::class);
        Route::get('permission/export', ExportPermissionController::class)->name('permission.export');
        Route::post('permission/import', ImportPermissionController::class)->name('permission.import');

        //assign permission
        Route::get('assign', [AssignPermissionController::class, 'index'])->name('assign.index');
        Route::get('assign/create', [AssignPermissionController::class, 'create'])->name('assign.create');
        Route::get('assign/{role}/edit', [AssignPermissionController::class, 'edit'])->name('assign.edit');
        Route::put('assign/{role}', [AssignPermissionController::class, 'update'])->name('assign.update');
        Route::post('assign', [AssignPermissionController::class, 'store'])->name('assign.store');

        //assign user to role
        Route::get('assign-user', [AssignUserToRoleController::class, 'index'])->name('assign.user.index');
        Route::get('assign-user/create', [AssignUserToRoleController::class, 'create'])->name('assign.user.create');
        Route::post('assign-user', [AssignUserToRoleController::class, 'store'])->name('assign.user.store');
        Route::get('assing-user/{user}/edit', [AssignUserToRoleController::class, 'edit'])->name('assign.user.edit');
        Route::put('assign-user/{user}', [AssignUserToRoleController::class, 'update'])->name('assign.user.update');
    });
});
