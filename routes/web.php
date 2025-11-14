<?php

// ALUMNI CONTROLLERS
use App\Http\Controllers\Alumni\RegistrationController;
use App\Http\Controllers\Alumni\HomeController;
use App\Http\Controllers\Alumni\ProfileController;
use App\Http\Controllers\Alumni\EducationController;
use App\Http\Controllers\Alumni\CareerController;
use App\Http\Controllers\Alumni\EventController;
use App\Http\Controllers\Alumni\ForumController;
use App\Http\Controllers\Alumni\JobController;
use App\Http\Controllers\Alumni\SubmittedJobController;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportCSVController;
use App\Http\Controllers\Admin\ExportPDFController;
use App\Http\Controllers\Admin\AlumniManagementController;
use App\Http\Controllers\Admin\ForumManagementController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Http\Controllers\Admin\JobManagementController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RecordController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\UserManagementController;

// ADMIN CONTROLLERS (ANALYTICS)
use App\Http\Controllers\Admin\Analytics\EmploymentRateController;
use App\Http\Controllers\Admin\Analytics\FurtherStudiesController;
use App\Http\Controllers\Admin\Analytics\JobRelevanceController;
use App\Http\Controllers\Admin\Analytics\UnemploymentPeriodController;
use App\Http\Controllers\Admin\Analytics\IndustrySectorController;
use App\Http\Controllers\Admin\Analytics\GeographicalDistributionController;
use App\Http\Controllers\Admin\Analytics\AlumniEngagementController;

// SHARED CONTROLLERS
use App\Http\Controllers\Shared\SkillController;
use App\Http\Controllers\Shared\ChangePasswordController;

use Illuminate\Support\Facades\Route;

// ERRORS ROUTE
Route::view('/admin/401', 'errors.admin-401')->name('admin.401');
Route::view('/admin/403', 'errors.admin-403')->name('admin.403');

Route::view('/alumni/401', 'errors.alumni-401')->name('alumni.401');
Route::view('/alumni/403', 'errors.alumni-403')->name('alumni.403');

// WELCOME ROUTE
Route::get('/', function () {
    Session::forget('registration');

    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role === 'alumni') {
            return redirect()->route('alumni.home');
        } elseif ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    }

    return view('alumni.welcome');
})->name('welcome');


// ALUMNI ROUTE
Route::middleware(['alumni'])->prefix('alumni')->group(function () {
    Route::get('add-skills', [RegistrationController::class, 'showSkillsForm'])->name('show.add.skills');
    Route::post('add-skills', [RegistrationController::class, 'storeSkills'])->name('alumni.skills.store');

    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('alumni.home');
        Route::get('news/{id}', [HomeController::class, 'show'])->name('alumni.news.view');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('alumni.profile');
        Route::post('update-basic', [ProfileController::class, 'updateBasic'])->name('alumni.profile.update.basic');
        Route::post('update-photo', [ProfileController::class, 'updatePhoto'])->name('alumni.profile.update.photo');
        Route::post('update-about', [ProfileController::class, 'updateAbout'])->name('alumni.profile.update.about');
        Route::get('search-skills', [ProfileController::class, 'searchSkills'])->name('alumni.profile.search.skills');
        Route::post('update-alumni-skills', [ProfileController::class, 'updateAlumniSkills'])->name('alumni.profile.update.skills');
    });

    Route::prefix('education')->group(function () {
        Route::get('/', [EducationController::class, 'index'])->name('alumni.education');
        Route::post('/update-education', [EducationController::class, 'updateEducation'])->name('alumni.update.education');
    });


    Route::prefix('career')->group(function () {
        Route::get('/', [CareerController::class, 'index'])->name('alumni.career');
        Route::post('update-employment-status', [CareerController::class, 'updateEmploymentStatus'])->name('alumni.update.employment.status');
        Route::post('update-first-employment', [CareerController::class, 'updateFirstEmployment'])->name('alumni.update.first.employment');
        Route::post('update-current-employment', [CareerController::class, 'updateCurrentEmployment'])->name('alumni.update.current.employment');
        Route::post('update-past-employment', [CareerController::class, 'updatePastEmployment'])->name('alumni.update.past.employment');
    });

    Route::prefix('events')->group(function () {
        Route::get('/', [EventController::class, 'index'])->name('alumni.events');
        Route::get('/{id}', [EventController::class, 'show'])->name('alumni.event.view');
        Route::post('/{id}/rsvp', [EventController::class, 'submitRSVP'])->name('alumni.event.rsvp');
    });

    Route::prefix('forum')->group(function () {
        Route::get('posts', [ForumController::class, 'index'])->name('post');
        Route::get('find-alumni', [ForumController::class, 'showFindAlumni'])->name('find.alumni');
        Route::get('view-profile/{id}', [ForumController::class, 'showProfile'])->name('view.profile');
        Route::get('add-post', [ForumController::class, 'showAddPost'])->name('add.post');
        Route::post('post', [ForumController::class, 'addPost'])->name('post.forum');
        Route::get('view-post/{id}', [ForumController::class, 'viewPost'])->name('view.post');
        Route::post('view-post/{id}', [ForumController::class, 'postComment'])->name('post.comment');
    });

    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('alumni.jobs');
        Route::get('{id}', [JobController::class, 'show'])->name('alumni.job.view');
    });

    Route::prefix('shared-jobs')->group(function () {
        Route::get('/', [SubmittedJobController::class, 'index'])->name('shared.jobs');
        Route::get('view/{id}', [SubmittedJobController::class, 'viewSharedJobs'])->name('shared.jobs.view');
    });

    Route::prefix('submitted-jobs')->group(function () {
        Route::get('my', [SubmittedJobController::class, 'mySubmissions'])->name('submitted.jobs');
        Route::get('add', [SubmittedJobController::class, 'showAddJob'])->name('show.submit.job');
        Route::post('add', [SubmittedJobController::class, 'storeSubmittedJob'])->name('submitted.jobs.store');

        Route::get('view/{id}', [SubmittedJobController::class, 'viewSubmittedJob'])->name('submitted.jobs.view');
        Route::put('update/{id}', [SubmittedJobController::class, 'updateSubmittedJob'])->name('submitted.jobs.update');

        Route::delete('delete/{id}', [SubmittedJobController::class, 'deleteSubmittedJob'])->name('submitted.jobs.delete');
    });

    Route::get('settings/change-password', [ChangePasswordController::class, 'index'])->name('alumni.change.password');
    Route::put('settings/update-password', [ChangePasswordController::class, 'updatePassword'])->name('alumni.update.password');
});


// ADMIN ROUTE
Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('export/csv', [ExportCSVController::class, 'exportCSV'])->name('admin.dashboard.export.csv');
        Route::post('export/pdf', [ExportPDFController::class, 'exportPDF'])->name('admin.dashboard.export.pdf');

        Route::get('employment-rate', [EmploymentRateController::class, 'index'])->name('employment-rate');
        Route::get('employment-rate/export/csv', [EmploymentRateController::class, 'exportCSV'])->name('employment.rate.export.csv');
        Route::get('employment-rate/export/pdf', [EmploymentRateController::class, 'exportPDF'])->name('employment.rate.export.pdf');

        Route::get('further-studies', [FurtherStudiesController::class, 'index'])->name('further-studies');
        Route::get('further-studies/export/csv', [FurtherStudiesController::class, 'exportCSV'])->name('further.studies.export.csv');
        Route::get('further-studies/export/pdf', [FurtherStudiesController::class, 'exportPDF'])->name('further.studies.export.pdf');

        Route::get('job-relevance', [JobRelevanceController::class, 'index'])->name('job-relevance');
        Route::get('job-relevance/export/csv', [JobRelevanceController::class, 'exportCSV'])->name('job.relevance.export.csv');
        Route::get('job-relevance/export/pdf', [JobRelevanceController::class, 'exportPDF'])->name('job.relevance.export.pdf');

        Route::get('unemployment-period', [UnemploymentPeriodController::class, 'index'])->name('unemployment-period');
        Route::get('unemployment-period/export/csv', [UnemploymentPeriodController::class, 'exportCSV'])->name('unemployment.period.export.csv');
        Route::get('unemployment-period/export/pdf', [UnemploymentPeriodController::class, 'exportPDF'])->name('unemployment.period.export.pdf');

        Route::get('industry-sector', [IndustrySectorController::class, 'index'])->name('industry-sector');
        Route::get('industry-sector/export/csv', [IndustrySectorController::class, 'exportCSV'])->name('industry.sector.export.csv');
        Route::get('industry-sector/export/pdf', [IndustrySectorController::class, 'exportPDF'])->name('industry.sector.export.pdf');

        Route::get('geographical-distribution', [GeographicalDistributionController::class, 'index'])->name('geographical-distribution');
        Route::get('geographical-distribution/export/csv', [GeographicalDistributionController::class, 'exportCSV'])->name('geographical.distribution.export.csv');
        Route::get('geographical-distribution/export/pdf', [GeographicalDistributionController::class, 'exportPDF'])->name('geographical.distribution.export.pdf');

        Route::get('alumni-engagement', [AlumniEngagementController::class, 'index'])->name('alumni-engagement');
        Route::get('alumni-engagement/export/csv', [AlumniEngagementController::class, 'exportCSV'])->name('alumni.engagement.export.csv');
        Route::get('alumni-engagement/export/pdf', [AlumniEngagementController::class, 'exportPDF'])->name('alumni.engagement.export.pdf');
    });

    Route::prefix('alumni-management')->group(function () {
        Route::get('/', [AlumniManagementController::class, 'index'])->name('alumni.management');
        Route::get('/alumni-records', [AlumniManagementController::class, 'showAlumniRecords'])->name('alumni.records');
        Route::get('{id}', [AlumniManagementController::class, 'show'])->name('alumni.view');
        Route::delete('{id}', [AlumniManagementController::class, 'destroy'])->name('alumni.management.destroy');
        Route::delete('{id}/delete-record', [AlumniManagementController::class, 'deleteAlumniRecord'])->name('alumni.records.destroy');
        Route::get('export/csv', [AlumniManagementController::class, 'exportCSV'])->name('alumni.management.export');
    });

    Route::prefix('forum-management')->group(function () {
        Route::get('/', [ForumManagementController::class, 'index'])->name('forum.management');
        Route::get('forum/{id}', [ForumManagementController::class, 'show'])->name('forum.view');
        Route::delete('forum/{id}', [ForumManagementController::class, 'destroy'])->name('forum.destroy');
    });

    Route::prefix('event-management')->group(function () {
        Route::get('/', [EventManagementController::class, 'index'])->name('event.management');
        Route::get('/view/{id}', [EventManagementController::class, 'show'])->name('event.view');
        Route::get('/add', [EventManagementController::class, 'create'])->name('event.add');
        Route::post('/add', [EventManagementController::class, 'store'])->name('event.store');
        Route::delete('/delete/{id}', [EventManagementController::class, 'destroy'])->name('event.delete');
        Route::put('/update/{id}', [EventManagementController::class, 'update'])->name('event.update');
    });

    Route::prefix('job-management')->group(function () {
        Route::get('/official-job-listings', [JobManagementController::class, 'index'])->name('official.job.listings');
        Route::delete('/official-job-listings/{id}', [JobManagementController::class, 'destroy'])->name('official.job.destroy');
        Route::get('/official-job-view/{id}', [JobManagementController::class, 'show'])->name('official.job.view');
        Route::put('/official-job-view/{id}', [JobManagementController::class, 'update'])->name('official.job.update');

        Route::get('/add-official-job', [JobManagementController::class, 'create'])->name('official.job.create');
        Route::post('/add-official-job', [JobManagementController::class, 'store'])->name('official.job.store');

        Route::get('/alumni-shared-jobs', [JobManagementController::class, 'alumniShared'])->name('alumni.shared.jobs');
        Route::delete('alumni-shared-jobs/{id}/delete', [JobManagementController::class, 'deleteShared'])->name('alumni.shared.jobs.delete');

        Route::get('/alumni-shared-jobs/view/{id}', [JobManagementController::class, 'viewShared'])->name('alumni.shared.jobs.view');
        Route::put('/alumni-shared-jobs/update/{id}', [JobManagementController::class, 'updateShared'])->name('alumni.shared.jobs.update');
    });

    Route::get('/skills/search', [SkillController::class, 'search'])->name('skills.search');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingsController::class, 'profile'])->name('settings');
        Route::put('update-profile', [SettingsController::class, 'updateProfile'])->name('settings.update.profile');

        Route::get('change-password', [SettingsController::class, 'changePassword'])->name('settings.password');
        Route::put('update-password', [ChangePasswordController::class, 'updatePassword'])->name('settings.update.password');

        Route::get('audit-logs', [RecordController::class, 'auditLogs'])->name('settings.audit');

        Route::get('add-records', [RecordController::class, 'records'])->name('settings.records');
        Route::get('download-alumni-template', [RecordController::class, 'downloadTemplate'])->name('settings.downloadTemplate');
        Route::post('import-alumni', [RecordController::class, 'importCSV'])->name('settings.importCSV');

        Route::get('news', [NewsController::class, 'showNews'])->name('settings.news');
        Route::post('news/{id?}', [NewsController::class, 'storeOrUpdate'])->name('settings.news.save');
        Route::delete('news/reset/{slot}', [NewsController::class, 'resetNews'])->name('settings.news.reset');
    });

    Route::prefix('user-management')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('user.management');
        Route::get('add-user', [UserManagementController::class, 'showAddUser'])->name('show.add.user');
        Route::post('add-user', [UserManagementController::class, 'addUser'])->name('store.user');

        Route::put('{id}/status', [UserManagementController::class, 'updateStatus'])->name('user.update.status');

        Route::get('view-user/{id}', [UserManagementController::class, 'viewUser'])->name('view.user');
        Route::delete('delete-user/{id}', [UserManagementController::class, 'deleteUser'])->name('delete.user');
    });
});

require __DIR__ . '/auth.php';
