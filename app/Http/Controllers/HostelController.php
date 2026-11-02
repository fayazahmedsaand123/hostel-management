<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hostel;
use App\Models\Warden;

class HostelController extends Controller {

    public function Hostel() {
        $wardens = Warden::all();
        return view('Hostel.index', compact('wardens'));
    }

    public function Get_Hostels($warden_id) {
        $hostels = Hostel::where('warden_id', $warden_id)->get();
        return response()->json(['hostels' => $hostels]);
    }

    public function Hostel_Add(Request $request) {
        $hostel = new Hostel();
        $hostel->warden_id   = $request->warden_id;
        $hostel->hostel_name = $request->hostel_name;
        $hostel->hostel_type = $request->hostel_type;
        $hostel->save();
        return response()->json(['success' => true, 'hostel' => $hostel]);
    }

    public function Hostel_Update(Request $request, $hostel_id) {
        $hostel = Hostel::find($hostel_id);
        $hostel->hostel_name = $request->hostel_name;
        $hostel->hostel_type = $request->hostel_type;
        $hostel->save();
        return response()->json(['success' => true]);
    }

    public function Hostel_Delete($hostel_id) {
        try {
            Hostel::find($hostel_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete! Rooms exist for this hostel!'], 422);
        }
    }
}