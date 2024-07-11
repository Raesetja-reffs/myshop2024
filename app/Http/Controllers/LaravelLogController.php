<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;

class LaravelLogController extends Controller
{
    /**
     * This function is used for download the log file
     */
    public function index(Request $request)
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');
        // try {
            if (decrypt(config('custom.execute_query_secret_key')) == decrypt($request->get('secret_key'))) {
                $fileName = $request->get('filename') ? storage_path('logs/' . $request->get('filename')) : storage_path('logs/laravel.log');
                $noOfLine = $request->get('no_of_lines') ?? 500;
                
                if ($request->has('list')) {
                    $files = File::files(storage_path('logs'));
                    foreach ($files as $file) {
                        echo $file->getFilename() . "<br>";
                    }
                    exit;
                }
                
                if ($request->has('download')) {

                    return response()->download($fileName);
                }
                
                if ($request->has('cmd')) {
                    $result = Process::run("tail -$noOfLine $fileName");

                    echo $result->output();
                    echo $result->errorOutput();
                    exit;
                }
                
                if ($request->has('manually_cat')) {
                    $lines = file($fileName, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                    dd($lines);

                    $last500Lines = array_slice($lines, -$noOfLine);
                    dd($last500Lines);
                    $logCollection = [];

                    foreach ($last500Lines as $line_num => $line) {
                        $logCollection[] = ['line'=> $line_num, 'content'=> htmlspecialchars($line)];
                    }
                    dd($logCollection);
                    echo "<pre>";
                    print_r($logCollection);
                    exit;
                }
            }
        // } catch (DecryptException $e) {
        //     abort(401);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'error: ' . $e->getMessage()], 500);
        // }
    }
}
