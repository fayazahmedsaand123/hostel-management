<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Hostel;
use App\Models\Warden;

class RoomController extends Controller {

    public function Room() {
        $wardens = Warden::all();
        return view('Room.index', compact('wardens'));
    }

    public function Get_Hostels($warden_id) {
        $hostels = Hostel::where('warden_id', $warden_id)->get();
        return response()->json(['hostels' => $hostels]);
    }

    public function Get_Rooms($hostel_id) {
        $rooms = Room::where('hostel_id', $hostel_id)->get();
        return response()->json(['rooms' => $rooms]);
    }

    public function Room_Add(Request $request) {
        $room = new Room();
        $room->hostel_id      = $request->hostel_id;
        $room->room_no        = $request->room_no;
        $room->capacity       = $request->capacity;
        $room->room_type      = $request->room_type;
        $room->rent_per_month = $request->rent_per_month;
        $room->save();
        return response()->json(['success' => true, 'room' => $room]);
    }

    public function Room_Update(Request $request, $room_id) {
        $room = Room::find($room_id);
        $room->room_no        = $request->room_no;
        $room->capacity       = $request->capacity;
        $room->room_type      = $request->room_type;
        $room->rent_per_month = $request->rent_per_month;
        $room->save();
        return response()->json(['success' => true]);
    }

    public function Room_Delete($room_id) {
        try {
            Room::find($room_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete! Allocations exist for this room!'], 422);
        }
    }
}