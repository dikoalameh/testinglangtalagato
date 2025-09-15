<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PdfExportController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\Form2AController;
Use App\Http\Controllers\ResearchController;
use Laravel\Tinker\ClassAliasAutoloader;
//use App\Http\Controllers\Form2BController;
//use App\Http\Controllers\Form2CController;
//use App\Http\Controllers\Form2DController;
//use App\Http\Controllers\Form5EController;
//use App\Http\Controllers\Form2EController;
//use App\Http\Controllers\Form2JController;
//use App\Http\Controllers\Form3AController;
//use App\Http\Controllers\Form3BController;
//use App\Http\Controllers\Form3DController;
//use App\Http\Controllers\Form3EController;
//use App\Http\Controllers\Form3CController;
//use App\Http\Controllers\Form3LController;

//data entry
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/send-otp', function () {
    return view('auth.send-otp');
})->name('send.otp');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('password.reset');

Route::get('/register-co-inv', function () {
    return view('auth.register-co-inv');
});

// erb
Route::get('/erb/research-records', function () {
    return view('erb.research-records');
});

Route::get('/erb/iro-approved-accounts', function () {
    return view('erb.iro-approved-accounts');
});

Route::get('/erb/approved-accounts', function () {
    return view('erb.approved-accounts');
});

Route::get('/erb/pending-reviews', function () {
    return view('erb.pending-reviews');
});

Route::get('/erb/assign-reviewer', function () {
    return view('erb.assign-reviewer');
});

Route::get('/erb/reviewers-checklist', function () {
    return view('erb.reviewers-checklist');
});

Route::get('/erb/dashboard', function () {
    return view('erb.dashboard');
});

Route::get('/erb/settings', function () {
    return view('erb.settings');
});

// iacuc
Route::get('/iacuc/research-records', function () {
    return view('iacuc.research-records');
});

Route::get('/iacuc/iro-approved-accounts', function () {
    return view('iacuc.iro-approved-accounts');
});

Route::get('/iacuc/approved-accounts', function () {
    return view('iacuc.approved-accounts');
});

Route::get('/iacuc/pending-reviews', function () {
    return view('iacuc.pending-reviews');
});

Route::get('/iacuc/assign-reviewer', function () {
    return view('iacuc.assign-reviewer');
});

Route::get('/iacuc/reviewers-checklist', function () {
    return view('iacuc.reviewers-checklist');
});

Route::get('/iacuc/dashboard', function () {
    return view('iacuc.dashboard');
});

Route::get('/iacuc/settings', function () {
    return view('iacuc.settings');
});

// superadmin
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
});

Route::get('/superadmin/accounts-classifications', function () {
    return view('superadmin.accounts-classifications');
});

Route::get('/superadmin/pending-reviews', function () {
    return view('superadmin.pending-reviews');
});

Route::get('/superadmin/permission-control', function () {
    return view('superadmin.permission-control');
});

Route::get('/superadmin/assign-reviewer', function () {
    return view('superadmin.assign-reviewer');
});

Route::get('/superadmin/research-records', function () {
    return view('superadmin.research-records');
});

Route::get('/superadmin/reviewers-checklist', function () {
    return view('superadmin.reviewers-checklist');
});

Route::get('/superadmin/monitoring', function() {
    return view('superadmin.monitoring');
});

Route::get('/superadmin/settings', function () {
    return view('superadmin.settings');
});

// reviewer
Route::get('/reviewer/dashboard', function () {
    return view('reviewer.dashboard');
});

Route::get('/reviewer/protocol-assign', function () {
    return view('reviewer.protocol-assign');
});

Route::get('/reviewer/settings', function () {
    return view('reviewer.settings');
});

// student
Route::get('/student/dashboard', function () {
    return view('student.dashboard');
});

Route::get('/student/submit-forms', function () {
    return view('student.submit-forms');
});

Route::get('/student/submit-tickets', function () {
    return view('student.submit-tickets');
});

Route::get('/student/download-forms', function () {
    return view('student.download-forms');
});

Route::get('/student/settings', function () {
    return view('student.settings');
});

// sample form layout
Route::get('/student/forms/form2a', function () {
    return view('student.forms.form2a');
});

Route::get('/student/forms/sampleform', function () {
    return view('student.forms.sampleform');
});

Route::get('/student/forms/form2b', function () {
    return view('student.forms.form2b');
});

Route::get('/student/forms/form2c', function () {
    return view('student.forms.form2c');
});

Route::get('/student/forms/form2d', function () {
    return view('student.forms.form2d');
});

Route::get('/student/forms/form5e',function () {
    return view('student.forms.form5e');
});

Route::get('/reviewer/forms/form2e',function () {
    return view('reviewer.forms.form2e');
});

Route::get('/reviewer/forms/form2j',function () {
    return view('reviewer.forms.form2j');
});

Route::get('/reviewer/forms/form3e',function () {
    return view('reviewer.forms.form3e');
});

//Storing Data through superadmin's permission-control
Route::get('/superadmin/permission-control', [RegisteredUserController::class, 'index'])->name('permission-control');
Route::post('/superadmin/store', [RegisteredUserController::class, 'addUser'])->name('superadmin.store');

//account classification
Route::get('/superadmin/accounts-classifications',[ClassificationController::class,'index'])->name('accounts-classifications');
Route::post('/classifications/{id}/update', [ClassificationController::class, 'update']);

Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

//Verification for login
Route::get('/superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->name('superadmin.dashboard');

Route::get('/erbadmin/dashboard', function () {
    return view('erbadmin.dashboard');
})->name('erbadmin.dashboard');

Route::get('/iacucadmin/dashboard', function () {
    return view('iacucadmin.dashboard');
})->name('iacucadmin.dashboard');

Route::get('/reviewer/dashboard', function () {
    return view('reviewer.dashboard');
})->name('reviewer.dashboard');

Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->name('student.dashboard');

//Storing Data for Form2A
Route::get('/student/download-forms', [Form2AController::class, 'index'])->name('download-forms');
Route::post('/student/store', [Form2AController::class, 'store'])->name('form2a.store');

//pdf exporter
Route::get('/export-form2a', [PdfExportController::class, 'exportForm2A'])->name('export.form2a');
Route::get('/export-form2b', [PdfExportController::class, 'exportForm2B'])->name('export.form2b');
Route::get('/export-form2c', [PdfExportController::class, 'exportForm2C'])->name('export.form2c');

//add new research information (Temporary Route)
Route::get('/research/create/{user_id}', [ResearchController::class, 'create'])
    ->name('research.create');
Route::post('/research/store', [ResearchController::class, 'store'])
    ->name('research.store');
//Storing Data for Form2B
//Route::get('/student/download-forms', [Form2BController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form2BController::class, 'store'])->name('form2b.store');
//Storing Data for Form2C
//Route::get('/student/download-forms', [Form2CController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form2CController::class, 'store'])->name('form2c.store');
//Storing Data for Form2D
//Route::get('/student/download-forms', [Form2DController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form2DController::class, 'store'])->name('form2d.store');
//Storing Data for Form5E
//Route::get('/student/download-forms', [Form5EController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form5EController::class, 'store'])->name('form5e.store');
//Storing Data for Form2E
//Route::get('/student/download-forms', [Form2EController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form2EController::class, 'store'])->name('form2e.store');
//Storing Data for Form2J
//Route::get('/student/download-forms', [Form2JController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form2JController::class, 'store'])->name('form2j.store');
//Storing Data for Form3A
//Route::get('/student/download-forms', [Form3AController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3AController::class, 'store'])->name('form3a.store');
//Storing Data for Form3B
//Route::get('/student/download-forms', [Form3BController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3BController::class, 'store'])->name('form3b.store');
//Storing Data for Form3D
//Route::get('/student/download-forms', [Form3DController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3DController::class, 'store'])->name('form3d.store');
//Storing Data for Form3E
//Route::get('/student/download-forms', [Form3EController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3EController::class, 'store'])->name('form3e.store');
//Storing Data for Form3C
//Route::get('/student/download-forms', [Form3CController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3CController::class, 'store'])->name('form3c.store');
//Storing Data for Form3L
//Route::get('/student/download-forms', [Form3LController::class, 'index'])->name('download-forms');
//Route::post('/student/store', [Form3LController::class, 'store'])->name('form3l.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// submit forms layout na mala ms teams
Route::get('student/submit-form-layout', function () {
    return view('student.submit-form-layout');
});

require __DIR__.'/auth.php';
