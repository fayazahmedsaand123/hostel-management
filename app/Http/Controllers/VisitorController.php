<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Models\Student;

class VisitorController extends Controller {

    public function Visitor() {
        $students = Student::all();
        return view('Visitor.index', compact('students'));
    }

    public function Get_Visitors($student_id) {
        $visitors = Visitor::where('student_id', $student_id)->get();
        return response()->json(['visitors' => $visitors]);
    }

    public function Visitor_Add(Request $request) {
        $visitor = new Visitor();
        $visitor->student_id    = $request->student_id;
        $visitor->visitor_name  = $request->visitor_name;
        $visitor->relation      = $request->relation;
        $visitor->visit_date    = $request->visit_date;
        $visitor->in_time       = $request->in_time;
        $visitor->out_time      = $request->out_time;
        $visitor->save();
        return response()->json(['success' => true, 'visitor' => $visitor]);
    }

    public function Visitor_Update(Request $request, $visitor_id) {
        $visitor = Visitor::find($visitor_id);
        $visitor->visitor_name = $request->visitor_name;
        $visitor->relation     = $request->relation;
        $visitor->visit_date   = $request->visit_date;
        $visitor->in_time      = $request->in_time;
        $visitor->out_time     = $request->out_time;
        $visitor->save();
        return response()->json(['success' => true]);
    }

    public function Visitor_Delete($visitor_id) {
        try {
            Visitor::find($visitor_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete!'], 422);
        }
    }
}