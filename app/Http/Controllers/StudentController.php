<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Mail\StudentRegistration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    protected $students;

    public function __construct()
    {
        $this->students = [
            [
                'id' => 0,
                'name' => 'Ace Raz Cabuga',
            ],
            [
                'id' => 1,
                'name' => 'Christian James T. Castillo',
            ],
            [
                'id' => 2,
                'name' => 'Christopher Pardinas Jabagat',
            ],
            [
                'id' => 3,
                'name' => 'Errol Rubic Sabanal',
            ],
            [
                'id' => 4,
                'name' => 'Eugene Rey C. Magoncia',
            ],
            [
                'id' => 5,
                'name' => 'Grace M. Penido',
            ],
            [
                'id' => 6,
                'name' => 'Gie-mar Roche',
            ],
            [
                'id' => 7,
                'name' => 'Jahs Caluag Morate',
            ],
            [
                'id' => 8,
                'name' => 'Joseph Beri Barrot',
            ],
            [
                'id' => 9,
                'name' => 'Joy V. Garcia',
            ],
            [
                'id' => 10,
                'name' => 'Junex D. Bandoy',
            ],
            [
                'id' => 11,
                'name' => 'Kenneth A. Dayo',
            ],
            [
                'id' => 12,
                'name' => 'Marcuel Lico Gubaynon',
            ],
            [
                'id' => 13,
                'name' => 'Mario B. Caday',
            ],
            [
                'id' => 14,
                'name' => 'Marlon Jhun M. Timogan',
            ],
            [
                'id' => 15,
                'name' => 'Paulo A. Duga',
            ],
            [
                'id' => 16,
                'name' => 'Rexon L. Timbal',
            ],
            [
                'id' => 17,
                'name' => 'Ronald N. Surita',
            ],
            [
                'id' => 18,
                'name' => 'Ronald P. Limbaga',
            ],
            [
                'id' => 19,
                'name' => 'Ronnel A. Falo',
            ],
            [
                'id' => 20,
                'name' => 'Stephen Angelo Astillero Basanez',
            ],
            [
                'id' => 21,
                'name' => 'Walter M. Lad',
            ],
        ];
    }

    /**
     * Get students from the session or fallback to default array.
     */
    protected function getStudents(): array
    {
        if (!session()->has('students')) {
            session(['students' => $this->students]);
        }

        return session('students', $this->students);
    }

    /**
     * Display a listing of students.
     * When hard refreshed (Ctrl+F5 / Ctrl+Shift+R), it resets back to the original array.
     */
    public function index(Request $request)
    {
        $cacheControl = strtolower((string) $request->header('Cache-Control'));
        $pragma = strtolower((string) $request->header('Pragma'));
        $isHardRefresh = str_contains($cacheControl, 'no-cache')
            || str_contains($pragma, 'no-cache');

        if ($isHardRefresh || !session()->has('students')) {
            session(['students' => $this->students]);
        }

        $students = $this->getStudents();

        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        return view('students.create');
    }

    /**
     * Store a newly created student into the session.
     */
    public function store(StudentRequest $request)
    {
        $validated = $request->validated();


        try {
            $students = $this->getStudents();

            $maxId = count($students) > 0 ? collect($students)->max('id') : -1;
            $newId = ($maxId === null || $maxId < 0) ? 0 : $maxId + 1;

            $students[] = [
                'id' => $newId,
                'name' => $validated['name'],
                'mail' => $validated['mail'] ?? '',
                'photo' => $request->hasFile('photo') ? $request->file('photo')->store('students', 'public') : null,
            ];

            session(['students' => array_values($students)]);

            Mail::to(
                config('mail.from.address')
            )->send(
                new StudentRegistration(
                    name: $validated['name'],
                    email: $validated['mail'] ?? '',
                )
            );

            return redirect()->route('students.index')
                ->with('success', 'Student created successfully!')
                ->with('student_name', $validated['name'])
                ->with('student_email', $validated['mail'] ?? '');


        } catch (Exception $ex) {
            return back()->withInput()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified student.
     */
    public function show($student)
    {
        $students = $this->getStudents();
        $item = collect($students)->firstWhere('id', (int) $student);

        if (!$item) {
            return redirect()->route('students.index')
                ->with('error', 'Student not found!');
        }

        return view('students.show', ['student' => $item]);
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit($student)
    {
        $students = $this->getStudents();
        $item = collect($students)->firstWhere('id', (int) $student);

        if (!$item) {
            return redirect()->route('students.index')
                ->with('error', 'Student not found!');
        }

        return view('students.edit', ['student' => $item]);
    }

    /**
     * Update the specified student in the session.
     */
    public function update(StudentRequest $request, $student)
    {
        $validated = $request->validated();

        try {
            $students = $this->getStudents();
            $found = false;

            $students = collect($students)->map(function ($p) use ($student, $validated, $request, &$found) {
                if ($p['id'] == (int) $student) {
                    $p['name'] = $validated['name'];
                    $p['mail'] = $validated['mail'] ?? '';

                    if ($request->hasFile('photo')) {
                        if (!empty($p['photo']) && Storage::disk('public')->exists($p['photo'])) {
                            Storage::disk('public')->delete($p['photo']);
                        }
                        $p['photo'] = $request->file('photo')->store('students', 'public');
                    }

                    $found = true;
                }
                return $p;
            })->all();

            if (!$found) {
                return redirect()->route('students.index')
                    ->with('error', 'Student not found!');
            }

            session(['students' => array_values($students)]);

            return redirect()->route('students.index')
                ->with('success', 'Student updated successfully!');
        } catch (Exception $ex) {
            return back()->withInput()->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified student from the session.
     */
    public function destroy($student)
    {
        try {
            $students = $this->getStudents();
            $initialCount = count($students);

            $removed = collect($students)->firstWhere('id', (int) $student);

            $students = collect($students)->reject(function ($p) use ($student) {
                return $p['id'] == (int) $student;
            })->values()->all();

            if (count($students) === $initialCount) {
                return redirect()->route('students.index')
                    ->with('error', 'Student not found!');
            }

            if (!empty($removed['photo']) && Storage::disk('public')->exists($removed['photo'])) {
                Storage::disk('public')->delete($removed['photo']);
            }

            session(['students' => $students]);

            return redirect()->route('students.index')
                ->with('success', 'Student deleted successfully!');
        } catch (Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
    }
}