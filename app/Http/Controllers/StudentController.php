<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Student; 
use Illuminate\Http\Request;
use App\Imports\StudentImport; 

use App\Http\Requests\StoreStudentRequest;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function index(Request $request)
{
    $query = Student::query();

    // Check if there is a search term
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where('cin', 'like', "%{$search}%")
              ->orWhere('nom', 'like', "%{$search}%")
              ->orWhere('prenom', 'like', "%{$search}%")
              ->orWhere('classe', 'like', "%{$search}%");
    }

    // Paginate the results
    $students = $query->paginate(10);

    return view('students.index', compact('students'));
}


    public function store(StoreStudentRequest $request) {
        // Since validation is handled by StoreStudentRequest, we directly move to creating the student
        
        Student::create([
            "cin" => $request->cin,
            "nom" => $request->nom,
            "prenom" => $request->prenom,
            "classe" => $request->classe,
        ]);

        return redirect()->route('students.index')->with('success', 'Étudiant ajouté avec succès.');
    }


    

    public function update(Request $request, $id)
{
    $request->validate([
        'cin' => 'required|string|max:255',
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'classe' => 'required|string|max:255',
    ]);

    $student = Student::findOrFail($id);
    $student->cin = $request->cin;
    $student->nom = $request->nom;
    $student->prenom = $request->prenom;
    $student->classe = $request->classe;
    $student->save();

    return redirect()->route('students.index')->with('success', 'Étudiant modifié avec succès!');
}
public function edit($id)
{
    $student = Student::findOrFail($id);
    return response()->json($student);
}

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès!');
    }

    public function importExcelData(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,csv,xls', // Accept only specific file types
        ]);

        // Import the data
        Excel::import(new StudentImport, $request->file('import_file'));

        return redirect()->back()->with('status', 'Importation réussie!');
    }
}
