<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class InvestigateController extends Controller
{
    public function storeInvestigate(Request $request)
    {
        $case_id = $request->case_id;
        $subfolder = "files_complaint/" . $case_id;

        $id = DB::table('tbl_case')->where('case_number', $case_id)->select('id')->first();

        try {



            if ($request->has('evidence')) {



                // Get the count of already uploaded files for the case

                foreach ($request->file('evidence') as $key => $file) {
                    try {
                        $ext =  $file->getClientOriginalExtension();
                        $filename = $case_id . '_' . ($key + 1).'_evidence';
                        $newFileName = $filename . '.'. $ext;

                        $fileSize = $file->getSize();
                        $fileSize /= 1024;

                        $formattedSize = number_format($fileSize, 2);
                        $floatSize = floatval($formattedSize);

                        DB::table('tbl_files')->insert([
                            'filename' => $filename,
                            'type' => $ext,
                            'size' => $floatSize,
                            'case_id' => $id->id,
                            'file_from' => 2
                        ]);
                    } catch (\Throwable $th) {
                        dd($th->getMessage());
                    }
                }

            }

            if ($request->solved_summary != null || $request->case_summary != null) {

                if ($request->evidence == null) {

                    if ($request->status == 3) {
                        $case = DB::table('tbl_case')->where('case_number', $request->case_id)
                            ->updateGetId([
                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);

                        return redirect()->route('viewcase', ['case_id' => $request->case_id])->with('success', '');
                    } else {

                        DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->update([
                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);
                    }
                } else {

                    if ($request->status == 3) {

                        $case = DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->updateGetId([

                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);


                        // DB::table('tbl_files')->where('case_id', $request->case_id)
                        //     ->update([
                        //         'filename' =>$file_name,
                        //         'type' => $ext,
                        //         'size' => $file->getClientSize(),
                        //         'case_id' => $case,
                        //     ]);

                        return redirect()->route('viewcase', ['case_id' => $request->case_id])->with('success', '');
                    } else {


                        $case = DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->updateGetId([

                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);

                        // DB::table('tbl_files')->where('case_id', $request->case_id)
                        // ->update([
                        //     'filename' =>$file_name,
                        //     'type' => $ext,
                        //     'size' => $file->getClientSize(),
                        //     'case_id' => $case ,
                        // ]);
                    }
                }
            } else {



                if ($request->evidence == null || $request->sloved_summary == null) {

                    if ($request->status == 1) {
                        DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->update([
                                'status' => '2',
                                'solved_by_user' => Auth::user()->id,

                            ]);
                    } else if ($request->status == 2) {
                        DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->update([

                                'solved_by_user' => Auth::user()->id,

                            ]);
                    } else if ($request->status == 4) {
                        DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->update([

                                'status' => $request->status,
                                'solved_by_user' => Auth::user()->id,

                            ]);
                    }
                } else {

                    $case = DB::table('tbl_case')->where('case_number', $request->case_id)

                        ->updateGetId([

                            'status' => '2',
                            'solved_by_user' => Auth::user()->id,



                        ]);

                    // DB::table('tbl_files')->where('case_id', $request->case_id)
                    // ->update([
                    //     'filename' =>$file_name,
                    //     'type' => $ext,
                    //     'size' => $file->getClientSize(),
                    //     'case_id' => $case,
                    // ]);
                }
            }



            if ($request->evidence != null) {
                // DB::table('tbl_case')->where('case_number', $request->case_id)

                //     ->update([


                //         'reference_files' => $dataTemp,


                //     ]);

                // DB::table('tbl_files')->where('case_id', $request->case_id)
                // ->update([
                //     'filename' =>$file_name,
                //     'type' => $ext,
                //     'size' => $file->getClientSize(),
                //     'case_id' => $request->case_id,
                // ]);
            }

            return redirect()->back()->with('success', 'ការបញ្ចូលទិន្នន័យបានជោគជ័យ');
        } catch (\Exception $e) {
            // If there's an error/exception, redirect back with an error message
            return redirect()->back()->with('error', 'ការបញ្ចូលទិន្នន័យមានបញ្ហា ' . $e->getMessage());
        }
    }




    public function downloadRecording(Request $request, $files)
    {
        return response()->download(public_path('recorded_voice/' . $files));
    }

    public function downloadFile(Request $request, $files)
    {
        return response()->download(public_path('files/' . $files));
    }
}
