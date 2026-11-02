<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Allocation;
use App\Models\Room;
use App\Models\Hostel;
use App\Models\Warden;

class FeeController extends Controller {

    public function Fee() {
        $wardens  = Warden::all();
        return view('Fee.index', compact('wardens'));
    }

    // Step 1 — Get Hostels by Warden
    public function Get_Hostels_For_Fee($warden_id) {
        $hostels = Hostel::where('warden_id', $warden_id)->get();
        return response()->json(['hostels' => $hostels]);
    }

    // Step 2 — Get Rooms by Hostel
    public function Get_Rooms_For_Fee($hostel_id) {
        $rooms = Room::where('hostel_id', $hostel_id)->get();
        return response()->json(['rooms' => $rooms]);
    }

    // Step 3 — Get Students allocated to this Room
    public function Get_Students_For_Fee($room_id) {
        $studentIds = Allocation::where('room_id', $room_id)
                                 ->where('status', 'Active')
                                 ->pluck('student_id');
        $students = Student::whereIn('student_id', $studentIds)->get();
        return response()->json(['students' => $students]);
    }

    // Step 4 — Get Fees for Student + room rent info
    // public function Get_Fees($student_id) {
    //     $fees      = Fee::where('student_id', $student_id)->get();
    //     $paid_fees = $fees->sum('amount');

    //     // Get room rent from active allocation
    //     $allocation     = Allocation::where('student_id', $student_id)
    //                                  ->where('status', 'Active')
    //                                  ->first();
    //     $rent_per_month = 0;
    //     if($allocation) {
    //         $room = Room::find($allocation->room_id);
    //         if($room) {
    //             $rent_per_month = $room->rent_per_month;
    //         }
    //     }

    //     $remaining = max(0, $rent_per_month - $paid_fees);

    //     return response()->json([
    //         'fees'            => $fees,
    //         'rent_per_month'  => number_format($rent_per_month, 2),
    //         'paid_fees'       => number_format($paid_fees, 2),
    //         'remaining_fees'  => number_format($remaining, 2),
    //     ]);
    // }
    public function Get_Fees($student_id) {
        $fees      = Fee::where('student_id', $student_id)->get();
        $paid_fees = $fees->sum('amount');

        $allocation     = Allocation::where('student_id', $student_id)
                                    ->where('status', 'Active')
                                    ->first();

        $rent_per_month = 0;
        $total_expected = 0;
        $remaining      = 0;

        if($allocation) {
            $room = Room::find($allocation->room_id);
            if($room) {
                $rent_per_month = $room->rent_per_month;

                // Total months since allot_date
                $allot_date     = \Carbon\Carbon::parse($allocation->allot_date);
                $months         = $allot_date->diffInMonths(now()) + 1;
                $total_expected = $months * $rent_per_month;

                // Remaining = total expected - total paid
                $remaining = $paid_fees == 0 ? 0 : ($rent_per_month - $paid_fees);
            }
        }

        return response()->json([
            'fees'            => $fees,
            'rent_per_month'  => number_format($rent_per_month, 2),
            'paid_fees'       => number_format($paid_fees, 2),
            'remaining_fees'  => number_format($remaining, 2),
        ]);
    }
    
    public function Fee_Add(Request $request) {

        // ===== Block 0 or negative amount =====
        if($request->amount <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Amount must be greater than 0!'
            ], 422);
        }

        $rent_per_month = 0;
        $allocation = Allocation::where('student_id', $request->student_id)
                                ->where('status', 'Active')
                                ->first();
        if($allocation) {
            $room = Room::find($allocation->room_id);
            if($room) {
                $rent_per_month = $room->rent_per_month;
            }
        }

        // Use Amount Per Month from request if user changed it
        if($request->amount_per_month && $request->amount_per_month > 0) {
            $rent_per_month = $request->amount_per_month;
        }

        // ===== Same month validation (skip if amount = 0) =====
        if($request->amount > 0) {
            $same_month_paid = Fee::where('student_id', $request->student_id)
                                ->where('month_for', $request->month_for)
                                ->sum('amount');

            if($rent_per_month > 0 && ($same_month_paid + $request->amount) > $rent_per_month) {
                $remaining_for_month = $rent_per_month - $same_month_paid;
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add! Month "' . $request->month_for . 
                                '" — Already paid Rs. ' . $same_month_paid . 
                                '. Remaining: Rs. ' . $remaining_for_month . '!'
                ], 422);
            }
        }

        // Save fee
        $fee = new Fee();
        $fee->student_id   = $request->student_id;
        $fee->amount       = $request->amount;
        $fee->pay_date     = $request->pay_date;
        $fee->month_for    = $request->month_for;
        $fee->payment_mode = $request->payment_mode;
        $fee->save();

        // ===== Calculate Credit/Extra =====
        $total_paid    = Fee::where('student_id', $request->student_id)->sum('amount');
        $total_months  = Fee::where('student_id', $request->student_id)->count();
        $total_expected = $rent_per_month * $total_months;
        $extra_paid    = $total_paid - $total_expected;

        $message = 'Added successfully!';
        $extra   = 0;

        if($extra_paid > 0 && $rent_per_month > 0) {
            $message = 'Added! You paid Rs. ' . $extra_paid . ' EXTRA — will adjust in next month!';
            $extra   = $extra_paid;
        }

        return response()->json([
            'success' => true,
            'fee'     => $fee,
            'message' => $message,
            'extra'   => $extra
        ]);
    }

    public function Fee_Update(Request $request, $fee_id) {
        $fee = Fee::find($fee_id);
        $fee->amount       = $request->amount;
        $fee->pay_date     = $request->pay_date;
        $fee->month_for    = $request->month_for;
        $fee->payment_mode = $request->payment_mode;
        $fee->save();
        return response()->json(['success' => true]);
    }

    public function Fee_Delete($fee_id) {
        try {
            Fee::find($fee_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete!'], 422);
        }
    }
}