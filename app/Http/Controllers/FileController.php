<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\File;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\DB;
use App\Models\ReservedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->id();
        $files= File::where('user_id', $user)->sort()->get();
        return $files;

    }


    public function create()
    {

        return view('file.uploadfile');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();
        $user = auth()->id();
       // $file ->store('/',$folder);
       // $fileOriginal =$file->getClientOriginalName() ;
      //  $name =explode('.' ,$fileOriginal);
       // $fileName = $name[0].'_'.now()->format('d_h_i_s').'.'.$name[1];
         $path = $request->file('file')->store('uploads');
        $file = File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'status' => 'free',
            'file_path'=>$path,
            'user_id' => $user
        ]);
        if ($file){
        DB::commit();
        return response()->json(['message' => 'created successfully']);
        }
        DB::rollBack();
        return response()->json(['message' => 'some thing went wrongs'], 450);

    }


    //     try{
    //     DB::beginTransaction();

    //     $file = File::lockForUpdate()->findOrFail($id);

    //     if ($file->status != 'free')
    //         return false;

    //     $user = auth::guard('user')->id();
    //     $file->status = 'taken';
    //     $reservedFile = ReservedFile::create([
    //         'user_id' => $user,
    //         'file_id' => $file->id,
    //         'type'=>'reserved',
    //     ]);
    //     $file->save();
    //     return $file;
    //     if(!$file)
    //     return response()->json(['message'=>'file reserved'],450);
    //     DB::commit();
    //     $path=Str::after(($file->name), 'storage');
    //   return  Storage::download('public/' . $path, $file->name);
    //    }

    //    catch(\Exception $ex){
    //     DB::rollBack();
    //     return response()->json(['message'=>$ex->getMessage()],444);
    // }

    public function download($id){

        try {
            DB::beginTransaction();

            $file = File::lockForUpdate()->find($id);

            if (!$file) {
                return response()->json(['message' => 'File not found.'], 404);
            }

            if ($file->status != 'free') {
                return response()->json(['message' => 'File is not available for download.'], 400);
            }

            $user = auth()->guard('user')->id();
            $file->status = 'taken';
            $reservedFile = ReservedFile::create([
                'user_id' => 1,
                'file_id' => $file->id,
                'type' => 'reserved',
            ]);
            $file->save();

            DB::commit();

            $path = Str::after($file->name, 'storage/');
            $filePath = storage_path('app/public/' . $path);

            return Storage::download($filePath, $file->name);
        } catch (\Exception $ex) {
            DB::rollBack();
            return response()->json(['message' => $ex->getMessage()], 500);
        }




     }


    public function show($id)
    {

    }


    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {

    }


    public function destroy($id)
    {

    }
}
