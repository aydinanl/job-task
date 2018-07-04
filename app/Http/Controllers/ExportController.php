<?php

namespace App\Http\Controllers;

use App\Helpers\ExportCsvHelper;
use App\Models\Course;
use App\Models\Students;
use Illuminate\Http\Request;

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
        $columns = array('Name', 'Surname', 'Email', 'Nationality', 'Course', 'University', 'StudentsCity');
        $data = [];

        //Data creation for columns.
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

        $csv = (new ExportCsvHelper($columns,$data));
        // Return CSV if there is no error.
        return $csv->has_error == false ? $csv->exportCSV() : response()->json($csv->error);
    }

    /**
     * Exports the total amount of students that are taking each course to a CSV file
     */
    public function exportCourseAttendenceToCSV()
    {
        $courses = Course::withCount('students')->get();

        //Columns' names.
        $columns = array('CourseID','CourseName', 'StudentCount');
        $data = [];

        //Data creation for columns.
        $row = 0;
        foreach ($courses as $course){
            $data[$row] = array(
                $course['id'],
                $course['course_name'],
                $course['students_count'],
            );
            $row++;
        }

        $csv = (new ExportCsvHelper($columns,$data));
        // Return CSV if there is no error.
        return $csv->has_error == false ? $csv->exportCSV() : response()->json($csv->error);
    }
}
