<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TODO;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll($pageNumber)
    {
        $data = TODO::where('user_id', '=', Auth::id())->paginate(2, ['*'], 'page', $pageNumber);
        if($data){ 
            return response()->json(['message' => $data],200);
        } 
        else{ 
            return $BaseController->sendError('record against this id does not exist.', ['errors'=>['record against this id does not exist']]);
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'   => 'required',
            'status' => 'required',
        ]);
   
        $BaseController = new BaseController;
        if($validator->fails()){
            return $BaseController->sendError('Validation Error.', $validator->errors());       
        }
        try{
            $todo_save = TODO::create([
                'user_id'     => Auth::id(),
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'status'      => $request->input('status'),

            ]);
            $todo_save = $todo_save->save();
            return $BaseController->sendResponse('success', 'Saved your Todo list successfully.');
        }
        catch(\Exception $e){
            return $BaseController->sendError('Failed to save your Todo list.', ['errors'=>['Failed to save your Todo list']]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('t_o_d_o_s')->select(['id','user_id', 'name','description','status'])->where([['id', '=',$id]])->get();
        if($data){ 
            return response()->json(['message' => $data],200);
        } 
        else{ 
            return $BaseController->sendError('record against this id does not exist.', ['errors'=>['record against this id does not exist']]);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'todo_id'     => 'required',
            'name'        => 'required',
            'description' => 'required',
            'status'      => 'required',
        ]);
   
        $BaseController = new BaseController;
        if($validator->fails()){
            return $BaseController->sendError('Validation Error.', $validator->errors());       
        }
        try{
            $updateTodo = TODO::where('id','=',$request->input('todo_id') )->update(array(
                'name'        => $request->input('name'),
                'description' => $request->input('description'),
                'status'      => $request->input('status'),
            ));
            return $BaseController->sendResponse('Updated', 'Updated your Todo list successfully.');
        }
        catch(\Exception $e){
            return $BaseController->sendError('Failed to update your Todo list.', ['errors'=>['Failed to update your Todo list']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $BaseController = new BaseController;
        try{
        $user = TODO::where('id', $id)->firstorfail()->delete();
            return $BaseController->sendResponse('Deleted', 'Deleted your Todo list successfully.');
        }
        catch(\Exception $e){
            return $BaseController->sendError('Failed to delete your Todo list.', ['errors'=>['Failed to delete your Todo list']]);
        }
    }
}
