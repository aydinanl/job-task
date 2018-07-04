<?php

namespace App\Http\Controllers;

use App\Helpers\ExportCsvHelper;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function __construct()
    {

    }

    public function welcome()
    {
        return view('hello');
    }

    /**
     * View all students found in the database
     */
    public function viewStudents()
    {
        $students = Students::with('course')->get();
        return view('view_students', compact(['students']));
    }

    /**
     * Exports selected student data to a CSV file
     */
    public function exportStudentsToCSV(Request $request)
    {
        $id = $request->studentId;
        if ($id === null){
            return redirect()
                ->back()
                ->with('error','No student selected.');
        }
        $students = Students::with('course','address')->whereIn('id',$id)->get();

        //Columns' names.
        $columns = array('Name', 'Surname', 'Email', 'Nationality', 'Course', 'University', 'City');
        $data = [];

        $row = 0;
        foreach ($students as $student){
            $data[$row] = array(
                $student['firstname'],
                $student['surname'],
                $student['email'],
                $student['nationality'],
                $student['course']['course_name'],
                $student['course']['university'],
                $student['address']['city'],
            );
            $row++;
        }

        return (new ExportCsvHelper($columns,$data))->exportCSV();
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exporttCourseAttendenceToCSV()
    {

    }
}
