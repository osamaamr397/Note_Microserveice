<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NoteController extends Controller
{
    use GeneralTrait;

    public function index(Request $request)
    {
        $userId = $request->input('user_id');
        $notes = Note::where('user_id', $userId)->get();

        return response()->json($notes);
    }

    public function store(Request $request)
    {
         $data = $request->validate([
            'title' => 'required|string',
            'cont' => 'required|string',

        ]);
         $user_id=$request->user_id;
         $data['user_id']=$user_id;

        $note = Note::create($data);
        return $this->returnSuccessMessage("$note",'201');

    }
    public function update(Request $request)
    {
        $data =  $request->validate([
            'title' => 'string',
            'cont' => 'string',
            'id'=>'required|integer'

        ]);
        $id=$data['id'];
        $user_id=$request->user_id;
        $data['user_id']=$user_id;
        $note = Note::findOrFail($id);

        $data['user_id']=$user_id;
        if($user_id==$note->user_id)
            $note->update($request->all());
        else
            return $this->returnError("403","not authorized");

        return $this->returnSuccessMessage("$note",'201');
    }



    public function show(Request $request)
    {
       $note_id= $request->id;
        $note = Note::findOrFail($note_id);

        return response()->json($note);
    }


    public function destroy(Request $request)
    {
        $data =  $request->validate([
            
            'id'=>'required|integer'

        ]);
        $id=$data['id'];
        $user_id=$request->user_id;
        $data['user_id']=$user_id;
        $note = Note::findOrFail($id);
        
        if($user_id==$note->user_id)
             $note->delete();
        else
            return $this->returnError("403","not authorized");
       

        return $this->returnSuccessMessage("Note Deleted Successfully");
    }
}
