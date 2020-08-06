<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\BackendUserController;
use App\Http\Controllers\OrientationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'HomeController@index');
Route::get('register/finish', 'HomeController@finishRegistration')->name('register.finish')->middleware('guest');



Auth::routes(['verify' => true]);


/**
 *
 *  SoSys ROUTES
 *
 */

/**
 * Show orientation details
*/
Route::get('orientation/{orientation}', 'OrientationController@show')->name('orientation')->middleware('auth');

/**
 * Create orientation
 */
Route::post('orientation', 'OrientationController@store')->name('orientation.store')->middleware('auth');

/**
 * Edit orientation
 */
Route::get('orientation/{orientation}/edit', 'OrientationController@edit')->name('orientation.edit')->middleware('auth');

/**
 * Update orientation
 */
Route::put('orientation/{orientation}/update', 'OrientationController@update')->name('orientation.update')->middleware('auth');

/**
 * Destroy orientation
 */
Route::delete('orientation/{orientation}', 'OrientationController@destroy')->middleware('auth');

/**
 * Mass Enroll students
 */
Route::put('orientation/{orientation}/enroll', 'OrientationController@enroll')->middleware('auth');

/**
 * Unenroll students
 */
Route::put('orientation/{orientation}/unenroll/{user}', 'OrientationController@unenroll')->middleware('auth');

/**
 * Orientation Statistics
 *
 * Here is where you can see the orientation completion status
 * (Not started, In progress, Completed) for each student enrolled.
 */
Route::get('orientation/{orientation}/stats', 'OrientationController@stats')->middleware('auth');

/**
 * Export
 */
Route::put('orientation/{orientation}/exportStats', 'OrientationController@exportStatistics')->middleware('auth');


/**
 *
 * SECTION ROUTES
 *
 */

/**
 * Create section
 */
Route::post('section', 'SectionController@store')->name('section.store')->middleware('auth');

/**
 * Create assessment section
 */
Route::post('assessment', 'AssessmentController@store')->middleware('auth');

/**
 * Update section
 */
Route::put('section/{section}', 'SectionController@update')->middleware('auth');

/**
 * Update assessment section
 */
Route::put('assessment/{section}', 'AssessmentController@update')->middleware('auth');

/**
 * Edit section
 */
Route::get('section/{section}/edit', 'SectionController@edit')->name('section.edit')->middleware('auth');

/**
 * Delete section
 */
Route::post('section/{section}/delete', 'SectionController@destroy')->name('section.destroy')->middleware('auth');

/**
 * Login and route based on user role
 */
Route::get('dashboard', 'UserController@index')->name('dashboard')->middleware('auth')->middleware('verified');

/**
 * Preview section
 */
Route::get('section/{section}/view', 'SectionController@show')->name('section.show')->middleware('auth');

/**
 * Create section
 * Takes the orientation id
 */
Route::get('section/create/{orientation_id}', 'SectionController@create')->name('section.create')->middleware('auth');

/**
 *
 * USERS ROUTES
 *
 */

Route::post('users', 'UserController@processInvites')->middleware('auth');

/**
 * Admin Retrieve all users
*/
Route::get('users', 'BackendUserController@index')->name('users')->middleware('auth');

/**
 * View single user details
 */
Route::get('users/{user}', 'BackendUserController@view')->name('user')->middleware('auth');

/**
 * Invite users
 */
Route::get('users/invite', 'UserController@invite')->middleware('auth');

/**
 * Re-send invitation
 */
Route::put('users/{invitee}/resend', 'UserController@resendInvite')->middleware('auth');

/**
 * Delete invitee
 */
Route::delete('users/{invitee}', 'UserController@deleteInvitee')->middleware('auth');


/**
 * Admin Update user
 */
Route::put('user/{user}/update', 'BackendUserController@update')->middleware('auth');



/**
 * Player
 */
Route::get('player/{orientation}/section/{section}', 'OrientationController@player')->middleware('auth');

Route::get('player/{orientation}/continue/{section}', 'OrientationController@continue')->name('continue')->middleware('auth');

Route::put('player/{orientation}/section/{section}', 'OrientationController@player')->name('player')->middleware('auth');

Route::put('player/{orientation}/finish/{section}', 'OrientationController@finish')->middleware('auth');


/**
 * Settings
 */
Route::put('settings/store', 'SettingsController@detailsUpdate')->name('detailsUpdate');
Route::put('settings/store/logo', 'SettingsController@logoUpdate')->name('logoUpdate');
Route::put('settings/store/frontpage', 'SettingsController@saveFrontPageCode');

Route::get('settings', 'SettingsController@index')->name('settings')->middleware('auth');
Route::get('settings/company', 'SettingsController@showCompanySettings')->name('company')->middleware('auth');
Route::get('settings/frontpage', 'SettingsController@showFrontPageSettings')->name('frontpage')->middleware('auth');



/**
 * User Profile
 */
Route::get('my', 'UserController@edit')->name('my')->middleware('auth');
Route::put('my/update', 'UserController@updateAvatar')->middleware('auth');
Route::put('my/updatePassword', 'UserController@updatePassword')->middleware('auth');




/**
 * =========
 * DOCUMENTS
 * =========
 */

/**
 * Show All Documents
 */
Route::get('documents', 'DocumentController@index')->name('documents')->middleware('auth');

/**
 * Create a document
 */
Route::get('documents/new', 'DocumentController@create')->middleware('auth');

/**
 * Edit a document
 */
Route::get('documents/{document}/edit', 'DocumentController@edit')->middleware('auth');

/**
 * Update a document
 */
Route::put('documents{document}/update', 'DocumentController@update')->middleware('auth');


/**
 * Delete a document
 */
Route::delete('documents/{document}/delete', 'DocumentController@delete')->middleware('auth');


/**
 * Store a document
 */
Route::post('documents', 'DocumentController@store')->middleware('auth');

/**
 * View a document (pdf)
 */
Route::get('documents/{document}', 'DocumentController@view')->middleware('auth');
Route::get('document/view/{document}', 'DocumentController@viewSigned')->middleware('auth');


/**
 * Attach a document to one or multiple orientations
 */
Route::put('documents/{document}/attach', 'DocumentController@attachToOrientation')->middleware('auth');

/**
 * Sign a document
 */
Route::put('documents/{document}/sign', 'DocumentController@sign')->middleware('auth');



