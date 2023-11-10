<?php

namespace App\Http\Controllers;

use App\Exports\caseExport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class pageController extends Controller
{
    public function dashboard()
    {
        $department = Auth::user()->department;
        $count_all_cases_posted = DB::table('tbl_case')->get()->count();

        $count_all_cases_department = DB::table('tbl_case')->where('department', $department)
            ->get()->count();

        $count_all_cases_received = DB::table('tbl_case')->where('department', $department)
            ->where('status', 1)
            ->get()->count();

        $count_all_cases_in_progress = DB::table('tbl_case')->where('department', $department)
            ->where('status', 2)
            ->get()->count();

        $count_all_cases_solved = DB::table('tbl_case')->where('department', $department)
            ->where('status', 3)
            ->get()->count();

        $count_all_cases_dismiss = DB::table('tbl_case')->where('department', $department)
            ->where('status', 4)
            ->get()->count();

        $getRecordToday = DB::table('tbl_case')
            ->select(
                'tbl_case.id', // specify the table name
                'case_number',
                'is_new',
                'sent_date',
                'complainer_tele',
                'status',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'complainer_name',
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', $department) // specify the table name
            ->whereDate('sent_date', Carbon::today())
            ->get();
        // dd($cases);

        return view('dashboard', [
            'post' => $count_all_cases_posted,
            'all' => $count_all_cases_department,
            'received' => $count_all_cases_received,
            'in_progress' => $count_all_cases_in_progress,
            'solved' => $count_all_cases_solved,
            'dismiss' => $count_all_cases_dismiss,
            'getRecordToday' => $getRecordToday,
        ]);
    }

    public function changeCredential()
    {
        return view('pages.changeCredential');
    }
    public function updateCredentials(Request $request)
    {
        $id = Auth::user()->id;

        if ($request->fullname == "" && $request->password == "") {
            return redirect()->back()->with('message', 'គ្មានការកែប្រែ');
        }


        if ($request->fullname != "") {
            DB::table('tbl_user_department')->where('id', $id)->update(['fullname' => $request->input('fullname')]);
        }

        if ($request->password != "") {
            $request->validate(
                [
                    'password' => ['min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]+$/'],
                ],
                [
                    'password' => 'មានកំហុស ត្រូវការមានអក្សរយ៉ាងតិច៨ និងមានលេខយ៉ាងតិច១',
                ]
            );
            DB::table('tbl_user_department')->where('id', $id)->update(['password' => Hash::make($request->input('password'))]);
        }

        return redirect()->back()->with('message', 'ជោគជ័យក្នុងការកែប្រែគណនី');
    }
    public function displayCases()
    {
        $departmentId = Auth::user()->department;
        $getRecordToday = DB::table('tbl_case')
            ->select(
                'tbl_case.id', // specify the table name
                'case_number',
                'is_new',
                'sent_date',
                'complainer_tele',
                'status',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'complainer_name',
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', $departmentId) // specify the table name
            ->whereDate('sent_date', Carbon::today())
            ->get();

        $getRecordThisWeek = DB::table('tbl_case')
            ->select(
                'tbl_case.id', // specify the table name
                'case_number',
                'is_new',
                'sent_date',
                'complainer_tele',
                'status',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'complainer_name',
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', $departmentId) // specify the table name
            ->whereBetween('sent_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->get();

        $getRecordThisMonth = DB::table('tbl_case')
            ->select(
                'tbl_case.id', // specify the table name
                'case_number',
                'is_new',
                'sent_date',
                'complainer_tele',
                'status',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'complainer_name',
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', $departmentId) // specify the table name
            ->whereMonth('sent_date', Carbon::now()->month)
            ->get();


        return view('pages.allCases', [
            'getRecordToday' => $getRecordToday,
            'getRecordThisWeek' => $getRecordThisWeek,
            'getRecordThisMonth' => $getRecordThisMonth
        ]);
    }
    public function casesFilter(Request $request)
    {
        $department = Auth::user()->department;

        if ((($request->start_date != null) && ($request->end_date != null)) && ($request->status != null) && ($request->case_number != null) && ($request->complainer_name != null) && ($request->complainer_tele != null)) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('status', $request->status)
                ->where('case_number', $request->case_number)
                ->where('complainer_name', $request->complainer_name)
                ->where('complainer_tele', $request->complainer_tele)
                ->whereBetween('sent_date', [$request->start_date, $request->end_date])
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        } else if (($request->start_date != null) && ($request->end_date != null)) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->whereBetween('sent_date', [$request->start_date, $request->end_date])
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        } else if ($request->status != null) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('status', $request->status)
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        } else if ($request->case_number != null) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('case_number', $request->case_number)
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        } else if ($request->complainer_name != null) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('complainer_name', $request->complainer_name)
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        }else if ($request->complainer_tele != null) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('complainer_tele', $request->complainer_tele)
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.casesFiltered', ['getRecord' => $cases]);
        }
        return redirect('cases');
    }
    public function showCase(Request $request)
    {
        $case = DB::table('tbl_case')
            ->select(
                'case_number',
                'sent_date',
                'case_summary',
                'is_new',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'received_date',
                'complainer_gender',
                'complainer_name',
                'complainer_age',
                'complainer_tele',
                'case_story',
                'tbl_case.department',
                'received_date',
                'voice_recorded',
                'status',
                'complainer_address',
                'files_provided',
                'case_summary',
                'solved_summary',
                'reference_files',
                'solved_by_user'
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', Auth::user()->department) // specify the table name
            ->where('case_number', $request->case_id)
            ->first();

        $location = DB::table('tbl_case')
            ->select('complainer_province', 'complainer_district', 'complainer_commune', 'complainer_village', 'complainer_name')
            ->where('case_number', $request->case_id)
            ->first();

        $province = DB::table('provinces')->select("name")->where('id', $location->complainer_province)->first();
        $district = DB::table('districts')->select("name")->where('id', $location->complainer_district)->first();
        $commune = DB::table('communes')->select("name")->where('id', $location->complainer_commune)->first();
        $village = DB::table('villages')->select("name")->where('id', $location->complainer_village)->first();


        return view(
            'pages/investigation',
            [
                'case' => $case,
                'province' => $province,
                'district' => $district,
                'commune' => $commune,
                'village' => $village,
                'files' => json_decode($case->files_provided),
                'reference_files' => explode("|", $case->reference_files),
                'audio_files' => explode(',', $case->voice_recorded)
            ]
        );
    }

    public function viewCase(Request $request)
    {


        $case = DB::table('tbl_case')
            ->select(
                'case_number',
                'sent_date',
                'case_summary',
                'is_new',
                'tbl_user_department.fullname as department_fullname',
                'tbl_user_officer.fullname as officer_fullname',
                'received_date',
                'complainer_gender',
                'complainer_name',
                'complainer_age',
                'complainer_tele',
                'case_story',
                'tbl_case.department',
                'received_date',
                'voice_recorded',
                'status',
                'complainer_address',
                'files_provided',
                'case_summary',
                'solved_summary',
                'reference_files',
                'solved_by_user'
            )
            ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
            ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
            ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
            ->where('tbl_case.department', Auth::user()->department) // specify the table name
            ->where('case_number', $request->case_id)
            ->first();

        $location = DB::table('tbl_case')
            ->select('complainer_province', 'complainer_district', 'complainer_commune', 'complainer_village', 'complainer_name')
            ->where('case_number', $request->case_id)
            ->first();

        $province = DB::table('provinces')->select("name")->where('id', $location->complainer_province)->first();
        $district = DB::table('districts')->select("name")->where('id', $location->complainer_district)->first();
        $commune = DB::table('communes')->select("name")->where('id', $location->complainer_commune)->first();
        $village = DB::table('villages')->select("name")->where('id', $location->complainer_village)->first();


        return view(
            'pages/viewCase',
            [
                'case' => $case,
                'province' => $province,
                'district' => $district,
                'commune' => $commune,
                'village' => $village,
                'files' => json_decode($case->files_provided),
                'reference_files' => explode("|", $case->reference_files),
                'audio_files' => explode(',', $case->voice_recorded)
            ]
        );
    }

    public function caseExport()
    {
        return Excel::download(new caseExport, Date('d-M-Y') . '-' . 'ពាក្យបណ្ដឹង.xlsx');
    }
    public function downloadPdf(Request $request)
    {
        $department = Auth::user()->department;

        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $current_date = date('d-m-y');
        $status = $request->input('status');

        if ((($start_date != null) && ($end_date != null)) && ($request->status != null)) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('status', $request->status)
                ->whereBetween('sent_date', [$start_date, $end_date])
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.downloadPdf', ['getRecord' => $cases, 'status' => $status, 'start_date' => $start_date, 'end_date' => $end_date, 'current_date' => $current_date]);
        } else if (($start_date != null) && ($end_date != null)) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->whereBetween('sent_date', [$start_date, $end_date])
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.downloadPdf', ['getRecord' => $cases, 'status' => $status, 'start_date' => $start_date, 'end_date' => $end_date, 'current_date' => $current_date]);
        } else if ($request->status != null) {
            $cases = DB::table('tbl_case')
                ->select(
                    'tbl_case.id', // specify the table name
                    'case_number',
                    'is_new',
                    'sent_date',
                    'complainer_tele',
                    'status',
                    'tbl_user_department.fullname as department_fullname',
                    'tbl_user_officer.fullname as officer_fullname',
                    'complainer_name',
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('status', $request->status)
                ->where('tbl_case.department', $department)
                ->orderBy('sent_date', 'asc')
                ->get();
            return view('pages.downloadPdf', ['getRecord' => $cases, 'status' => $status, 'start_date' => $start_date, 'end_date' => $end_date, 'current_date' => $current_date]);
        }
        return redirect('downloadPdf');
    }
    public function getFile($case_id, $file)
    {
        $path = "files_complaint/" . $case_id . "/" . $file;
        return Storage::disk('spaces')->download($path);
    }
    public function deleteFile(Request $request, $case_id, $file)
    {
        $subfolder = "files_complaint/" . $case_id;
        $file_path = $subfolder . '/' . $file;

        // Delete the file from the storage
        Storage::disk('spaces')->delete($file_path);

        // Delete the file from the database
        // Fetch the record
        $record = DB::table('tbl_case')->where('case_number', $case_id)->first();

        if ($record) {
            // Split the files string into an array
            $files = explode('|', $record->reference_files);

            // Remove the file from the array
            $files = array_filter($files, function ($value) use ($file) {
                return $value != $file;
            });

            // Join the array back into a string
            $updatedFiles = implode('|', $files);

            // Update the record in the database
            DB::table('tbl_case')->where('case_number', $case_id)->update(['reference_files' => $updatedFiles]);
        }


        return redirect()->back()->with('success', 'លុបឯកសារបានជោគជ័យ');
    }



    public function dashboardCase(Request $request)
    {
        $departmentId = Auth::user()->department;
        $status = $request->input('status', 'all');
        $current_date = date('d-m-y');

        if ($status === 'all') {
            $getRecord = DB::table('tbl_case')
                ->select(
                    'case_number',
                    'sent_date',
                    'case_summary',
                    'is_new',
                    'tbl_user_department.fullname as department_fullname', // specify the table name
                    'tbl_user_officer.fullname as officer_fullname', // specify the table name
                    'received_date',
                    'complainer_gender',
                    'complainer_name',
                    'complainer_age',
                    'complainer_tele',
                    'case_story',
                    'tbl_case.department', // specify the table name
                    'received_date',
                    'voice_recorded',
                    'status',
                    'complainer_address',
                    'files_provided',
                    'case_summary',
                    'solved_summary',
                    'reference_files',
                    'solved_by_user'
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('tbl_case.department', $departmentId)
                ->get();
        } else {
            $getRecord = DB::table('tbl_case')
                ->select(
                    'case_number',
                    'sent_date',
                    'case_summary',
                    'is_new',
                    'tbl_user_department.fullname as department_fullname', // specify the table name
                    'tbl_user_officer.fullname as officer_fullname', // specify the table name
                    'received_date',
                    'complainer_gender',
                    'complainer_name',
                    'complainer_age',
                    'complainer_tele',
                    'case_story',
                    'tbl_case.department', // specify the table name
                    'received_date',
                    'voice_recorded',
                    'status',
                    'complainer_address',
                    'files_provided',
                    'case_summary',
                    'solved_summary',
                    'reference_files',
                    'solved_by_user'
                )
                ->join('tbl_department', 'tbl_case.department', '=', 'tbl_department.id')
                ->leftJoin('tbl_user_officer', 'tbl_case.posted_by_user', '=', 'tbl_user_officer.id')
                ->leftJoin('tbl_user_department', 'tbl_case.solved_by_user', '=', 'tbl_user_department.id')
                ->where('tbl_case.department', $departmentId)
                ->where('status', $status)
                ->get();
        }

        return view('pages.dashboardCase', [
            'getRecord' => $getRecord,
            'current_date' => $current_date,
            'status' => $status,
        ]);
    }
    public function report()
    {
        $department = Auth::user()->department;
        $current_date = date('d-m-y');

        $count_all_cases_department = DB::table('tbl_case')->where('department', $department)
            ->get()->count();

        $count_all_cases_received = DB::table('tbl_case')->where('department', $department)
            ->where('status', 1)
            ->get()->count();

        $count_all_cases_in_progress = DB::table('tbl_case')->where('department', $department)
            ->where('status', 2)
            ->get()->count();

        $count_all_cases_solved = DB::table('tbl_case')->where('department', $department)
            ->where('status', 3)
            ->get()->count();

        $count_all_cases_dismiss = DB::table('tbl_case')->where('department', $department)
            ->where('status', 4)
            ->get()->count();
        return view(
            'pages.report',
            [
                'all' => $count_all_cases_department,
                'received' => $count_all_cases_received,
                'in_progress' => $count_all_cases_in_progress,
                'solved' => $count_all_cases_solved,
                'dismiss' => $count_all_cases_dismiss,
                'current_date' => $current_date,
            ]
        );
    }
}
