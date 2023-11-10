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
        $image = array();

        $audio_files = array();

        try {



            if ($files = $request->file('evidence')) {
                $index = 1; // Initialize a counter
                $image = []; // Initialize an array to store new file names

                foreach ($files as $file) {
                    // Add 'video/mp4', 'audio/mpeg' to the array
                    if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'application/pdf', 'video/mp4', 'audio/mpeg'])) {
                        continue;
                    }

                    $file_name = $request->case_id . '_' . $index; // Append the counter to the case_id
                    $ext = strtolower($file->getClientOriginalExtension());
                    $file_full_name = $file_name . '.' . $ext;

                    // Store the file in 'spaces' disk and get the path
                    $file->storeAs($subfolder, $file_full_name, 'spaces');

                    array_push($image, $file_full_name); // Store only the file name and extension

                    $index++; // Increment the counter for each file
                }

                // Fetch existing files from the database
                $existingFiles = DB::table('tbl_case')->where('case_number', $request->case_id)->pluck('reference_files')->first();
                $existingFiles = explode('|', $existingFiles);

                // Merge existing files with new ones
                $image = array_merge($existingFiles, $image);
            }
            if ($request->solved_summary != null || $request->case_summary != null) {

                if ($request->evidence == null ) {

                    if ($request->status == 3) {
                        $case = DB::table('tbl_case')->where('case_number', $request->case_id)
                            ->update([
                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);

                            return redirect()->route('viewcase', ['case_id'=> $request->case_id])->with('success','');
                        }else {

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

                            ->update([


                                'reference_files' => implode('|', $image),

                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);

                            return redirect()->route('viewcase', ['case_id'=> $request->case_id])->with('success','');

                    } else {


                        DB::table('tbl_case')->where('case_number', $request->case_id)

                            ->update([


                                'reference_files' => implode('|', $image),

                                'case_summary' => $request->case_summary,
                                'solved_summary' => $request->solved_summary,
                                'solved_by_user' => Auth::user()->id,
                                'status' => $request->status,
                            ]);
                    }
                }
            } else {



                if ($request->evidence == null || $request->sloved_summary == null ) {

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

                    DB::table('tbl_case')->where('case_number', $request->case_id)

                        ->update([

                            'status' => '2',
                            'solved_by_user' => Auth::user()->id,
                            'reference_files' => implode('|', $image),


                        ]);
                }
            }

            $dataTemp =  implode('|', $image);


            if(strlen($dataTemp)> 0){

                if($dataTemp [0] == '|'){
                    $dataTemp = substr($dataTemp, 1);

                }
            }


            if($request->evidence != null){
                DB::table('tbl_case')->where('case_number', $request->case_id)

            ->update([


                'reference_files' =>$dataTemp,


            ]);
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
