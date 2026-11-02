<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Student;
use App\Models\Room;
use App\Models\Hostel;
use App\Models\Warden;

class AllocationController extends Controller {

    public function Allocation() {
        $wardens = Warden::all();
        // $hostels = \App\Models\Hostel::all();
        return view('Allocation.index', compact('wardens'));
    }

    // Step 1 — Get Hostels by Warden
    public function Get_Hostels_For_Allocation($warden_id) {
        $hostels = Hostel::where('warden_id', $warden_id)->get();
        return response()->json(['hostels' => $hostels]);
    }

    // Step 2 — Get Rooms with Vacancy Check
    public function Get_Rooms_For_Allocation($hostel_id) {
        $rooms = Room::where('hostel_id', $hostel_id)->get();

        $roomData = [];
        foreach($rooms as $room) {
            // Count active allocations for this room
            $allocated = Allocation::where('room_id', $room->room_id)
                                   ->where('status', 'Active')
                                   ->count();
            $vacant = $room->capacity - $allocated;

            $roomData[] = [
                'room_id'       => $room->room_id,
                'room_no'       => $room->room_no,
                'capacity'      => $room->capacity,
                'allocated'     => $allocated,
                'vacant'        => $vacant,
                'is_full'       => $vacant <= 0,
                'room_type'     => $room->room_type,
                'rent_per_month'=> $room->rent_per_month,
            ];
        }

        // Check if ALL rooms are full
        $allFull = collect($roomData)->every(fn($r) => $r['is_full']);

        return response()->json([
            'rooms'   => $roomData,
            'allFull' => $allFull
        ]);
    }

    // Step 3 — Get only Unallocated Students
    public function Get_Available_Students() {
        // Get student IDs that already have ACTIVE allocation
        $allocatedStudentIds = Allocation::where('status', 'Active')
                                         ->pluck('student_id')
                                         ->toArray();

        // Get students NOT in that list
        $students = Student::whereNotIn('student_id', $allocatedStudentIds)->get();

        return response()->json(['students' => $students]);
    }

    // Get existing allocations by student
    public function Get_Allocations($student_id) {
        $allocations = Allocation::where('student_id', $student_id)->get();
        return response()->json(['allocations' => $allocations]);
    }

    // Add Allocation with Capacity Check
    public function Allocation_Add(Request $request) {
        $room = Room::find($request->room_id);

        if(!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room not found!'
            ], 422);
        }

        // Count current active allocations
        $allocated = Allocation::where('room_id', $request->room_id)
                               ->where('status', 'Active')
                               ->count();

        // Check if room is full
        if($allocated >= $room->capacity) {
            return response()->json([
                'success' => false,
                'message' => 'Room Capacity Full! This room can only have ' . $room->capacity . ' students. Currently ' . $allocated . ' students allocated!'
            ], 422);
        }

        // Check if student already allocated
        $alreadyAllocated = Allocation::where('student_id', $request->student_id)
                                      ->where('status', 'Active')
                                      ->exists();

        if($alreadyAllocated) {
            return response()->json([
                'success' => false,
                'message' => 'This student is already allocated to a room!'
            ], 422);
        }

        $allocation = new Allocation();
        $allocation->student_id  = $request->student_id;
        $allocation->room_id     = $request->room_id;
        $allocation->allot_date  = $request->allot_date;
        $allocation->leave_date  = $request->leave_date;
        $allocation->status      = $request->status ?? 'Active';
        $allocation->save();

        // Check vacancy after adding
        $newAllocated = $allocated + 1;
        $vacant       = $room->capacity - $newAllocated;

        return response()->json([
            'success'    => true,
            'allocation' => $allocation,
            'vacant'     => $vacant,
            'message'    => $vacant == 0
                ? 'Added! Room is now FULL!'
                : 'Added successfully! ' . $vacant . ' slot(s) remaining.'
        ]);
    }

    // Update Allocation
    public function Allocation_Update(Request $request, $allocation_id) {
        $allocation = Allocation::find($allocation_id);
        $allocation->room_id    = $request->room_id;
        $allocation->allot_date = $request->allot_date;
        $allocation->leave_date = $request->leave_date;
        $allocation->status     = $request->status;
        $allocation->save();
        return response()->json(['success' => true]);
    }

    // Delete Allocation
    public function Allocation_Delete($allocation_id) {
        try {
            Allocation::find($allocation_id)->delete();
            return response()->json(['success' => true]);
        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete!'
            ], 422);
        }
    }
}