<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warden;

class WardenController extends Controller {

    public function Home() {
        return view('home');
    }

    public function Index() {
        $wardens = Warden::all();
        return view('warden.index',compact('wardens'));
    }

    public function Add_Warden(Request $request) {
        $add_warden = new Warden();
        $add_warden->warden_name = $request->warden_name;
        $add_warden->email = $request->email;
        $add_warden->phone = $request->phone;
        $add_warden->save();
        return response()->json(['success' => true, 'warden' => $add_warden]);
    }

    public function Warden_Update(Request $request, $warden_id) {
        $warden = Warden::find($warden_id);
        $warden->warden_name = $request->warden_name;
        $warden->phone       = $request->phone;
        $warden->email       = $request->email;
        $warden->save();
        return response()->json(['success' => true]);
    }

    public function Warden_Delete($warden_id) {
        try {
            Warden::find($warden_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete! Hostels exist for this warden!'], 422);
        }
    }
}
