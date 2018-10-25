<?php

namespace App\Http\Controllers;
use App\Member;
class MemberController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index(){
        $data = Member::all();
        return response($data);
    }
    public function show($id){
        $data = Member::where('id',$id)->get();
        return response ($data);
    }
    public function store (Request $request){
        $data = new Member();
        $data->activity = $request->input('activity');
        $data->description = $request->input('description');
        $data->save();
    
        return response('Berhasil Tambah Data');
    }
    public function update(Request $request, $id)
    {
        $product = Member::find($id);
        $product->update($request->all());

        return response()->json([
            'message' => 'Successfull update member'
        ]);
    }

    public function delete($id)
    {
        Member::destroy($id);

        return response()->json([
            'message' => 'Successfull delete member'
        ]);
    }
}
