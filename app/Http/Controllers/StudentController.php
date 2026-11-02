<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller {

    public function Student() {
        $students = Student::all();
        return view('Student.index', compact('students'));
    }

    public function Student_Add(Request $request) {
        $student = new Student();
        $student->name       = $request->name;
        $student->gender     = $request->gender;
        $student->dob        = $request->dob;
        $student->phone      = $request->phone;
        $student->email      = $request->email;
        $student->department = $request->department;
        $student->city       = $request->city;
        $student->join_date  = $request->join_date;
        $student->save();
        return response()->json(['success' => true, 'student' => $student]);
    }

    public function Student_Update(Request $request, $student_id) {
        $student = Student::find($student_id);
        $student->name       = $request->name;
        $student->gender     = $request->gender;
        $student->dob        = $request->dob;
        $student->phone      = $request->phone;
        $student->email      = $request->email;
        $student->department = $request->department;
        $student->city       = $request->city;
        $student->join_date  = $request->join_date;
        $student->save();
        return response()->json(['success' => true]);
    }

    public function Student_Delete($student_id) {
        try {
            Student::find($student_id)->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Cannot delete! Records exist for this student!'], 422);
        }
    }
}