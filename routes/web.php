<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WardenController;
use App\Http\Controllers\HostelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AllocationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\ComplaintController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Guest routes — only if NOT logged in
Route::middleware('guest')->group(function() {
    Route::get('/', function() { return redirect()->route('login'); });
    Route::get('/login',    [AuthController::class, 'Login'])->name('login');
    Route::post('/login',   [AuthController::class, 'Login_Post'])->name('login_post');
    Route::get('/register', [AuthController::class, 'Register'])->name('register');
    Route::post('/register',[AuthController::class, 'Register_Post'])->name('register_post');
    Route::get('/forgot',   [AuthController::class, 'Forgot'])->name('forgot');
    Route::post('/forgot',  [AuthController::class, 'Forgot_Post'])->name('forgot_post');
    Route::get('/reset/{token}',  [AuthController::class, 'Reset'])->name('password.reset');
    Route::post('/reset',         [AuthController::class, 'Reset_Post'])->name('reset_post');
});

// Auth routes — only if logged in
Route::middleware('auth')->group(function() {
    // logout
    Route::post('/logout', [AuthController::class, 'Logout'])->name('logout');

    // Change passoword
    Route::post('/change_password', [AuthController::class, 'Change_Password'])->name('change_password');

    // Home
    Route::get('/home', [WardenController::class, 'Home'])->name('home');

    // Warden
    Route::get('/warden',[WardenController::class,'Index'])->name('warden');
    Route::post('/add_warden',[WardenController::class,'Add_Warden'])->name('add_warden');
    Route::post('/warden_update/{warden_id}', [WardenController::class, 'Warden_Update']);
    Route::post('/warden_delete/{warden_id}', [WardenController::class, 'Warden_Delete']);

    // Hostel
    Route::get('/hostel', [HostelController::class, 'Hostel'])->name('hostel');
    Route::get('/get_hostels/{warden_id}', [HostelController::class, 'Get_Hostels']);
    Route::post('/hostel_add', [HostelController::class, 'Hostel_Add'])->name('hostel_add');
    Route::post('/hostel_update/{hostel_id}', [HostelController::class, 'Hostel_Update']);
    Route::post('/hostel_delete/{hostel_id}', [HostelController::class, 'Hostel_Delete']);

    // Room
    Route::get('/room', [RoomController::class, 'Room'])->name('room');
    Route::get('/get_wardens_for_room', [RoomController::class, 'Get_Wardens']);
    Route::get('/get_hostels_for_room/{warden_id}', [RoomController::class, 'Get_Hostels']);
    Route::get('/get_rooms/{hostel_id}', [RoomController::class, 'Get_Rooms']);
    Route::post('/room_add', [RoomController::class, 'Room_Add'])->name('room_add');
    Route::post('/room_update/{room_id}', [RoomController::class, 'Room_Update']);
    Route::post('/room_delete/{room_id}', [RoomController::class, 'Room_Delete']);

    // Student
    Route::get('/student', [StudentController::class, 'Student'])->name('student');
    Route::post('/student_add', [StudentController::class, 'Student_Add'])->name('student_add');
    Route::post('/student_update/{student_id}', [StudentController::class, 'Student_Update']);
    Route::post('/student_delete/{student_id}', [StudentController::class, 'Student_Delete']);

    // Allocation    
    Route::get('/allocation', [AllocationController::class, 'Allocation'])->name('allocation');
    Route::get('/get_hostels_for_allocation/{warden_id}', [AllocationController::class, 'Get_Hostels_For_Allocation']);
    Route::get('/get_rooms_for_allocation/{hostel_id}',   [AllocationController::class, 'Get_Rooms_For_Allocation']);
    Route::get('/get_available_students',                  [AllocationController::class, 'Get_Available_Students']);
    Route::get('/get_allocations/{student_id}',            [AllocationController::class, 'Get_Allocations']);
    Route::post('/allocation_add',                         [AllocationController::class, 'Allocation_Add'])->name('allocation_add');
    Route::post('/allocation_update/{allocation_id}',      [AllocationController::class, 'Allocation_Update']);
    Route::post('/allocation_delete/{allocation_id}',      [AllocationController::class, 'Allocation_Delete']);

    // Fee
    // Route::get('/fee', [FeeController::class, 'Fee'])->name('fee');
    // Route::get('/get_fees/{student_id}', [FeeController::class, 'Get_Fees']);
    // Route::post('/fee_add', [FeeController::class, 'Fee_Add'])->name('fee_add');
    // Route::post('/fee_update/{fee_id}', [FeeController::class, 'Fee_Update']);
    // Route::post('/fee_delete/{fee_id}', [FeeController::class, 'Fee_Delete']);
    
    // Fee
    Route::get('/fee', [FeeController::class, 'Fee'])->name('fee');
    Route::get('/get_hostels_for_fee/{warden_id}',  [FeeController::class, 'Get_Hostels_For_Fee']);
    Route::get('/get_rooms_for_fee/{hostel_id}',    [FeeController::class, 'Get_Rooms_For_Fee']);
    Route::get('/get_students_for_fee/{room_id}',   [FeeController::class, 'Get_Students_For_Fee']);
    Route::get('/get_fees/{student_id}',            [FeeController::class, 'Get_Fees']);
    Route::post('/fee_add',                         [FeeController::class, 'Fee_Add'])->name('fee_add');
    Route::post('/fee_update/{fee_id}',             [FeeController::class, 'Fee_Update']);
    Route::post('/fee_delete/{fee_id}',             [FeeController::class, 'Fee_Delete']);

    // Visitor
    Route::get('/visitor', [VisitorController::class, 'Visitor'])->name('visitor');
    Route::get('/get_visitors/{student_id}', [VisitorController::class, 'Get_Visitors']);
    Route::post('/visitor_add', [VisitorController::class, 'Visitor_Add'])->name('visitor_add');
    Route::post('/visitor_update/{visitor_id}', [VisitorController::class, 'Visitor_Update']);
    Route::post('/visitor_delete/{visitor_id}', [VisitorController::class, 'Visitor_Delete']);

    // Complaint
    Route::get('/complaint', [ComplaintController::class, 'Complaint'])->name('complaint');
    Route::get('/get_complaints/{student_id}', [ComplaintController::class, 'Get_Complaints']);
    Route::post('/complaint_add', [ComplaintController::class, 'Complaint_Add'])->name('complaint_add');
    Route::post('/complaint_update/{complaint_id}', [ComplaintController::class, 'Complaint_Update']);
    Route::post('/complaint_delete/{complaint_id}', [ComplaintController::class, 'Complaint_Delete']);
});