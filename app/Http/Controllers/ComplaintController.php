<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Complaint;
use App\Models\Student;

class ComplaintController extends Controller {

    public function Complaint() {
        $students = Student::all();
        return view('Complaint.index', compact('students'));
    }

    public function Get_Complaints($student_id) {
        $complaints = Complaint::where('student_id', $student_id)->get();
        return response()->json(['complaints' => $complaints]);
    }

    public function Complaint_Add(Request $request) {
        $complaint = new Complaint();
        $complaint->student_id      = $request->student_id;
        $complaint->complaint_type  = $request->complaint_type;
        $complaint->description     = $request->description;
        $complaint->complaint_date  = $request->complaint_date;
        $complaint->status          = $request->status;
        $complaint->save();
        return response()->json(['success' => true, 'complaint' => $complaint]);
    }

    public function Complaint_Update(Request $request, $complaint_id) {
        $complaint = Complaint::find($complaint_id);
        $complaint->complaint_type = $request->complaint_type;
        $complaint->description    = $request->description;
        $complaint->complaint_date = $request->complaint_date;
        $complaint->status         = $request->status;
        $complaint->save();
        return response()->json(['success' => true]);
    }

    public function Complaint_Delete($complaint_id) {
        try {
            Complaint::find($complaint_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete!'], 422);
        }
    }
}