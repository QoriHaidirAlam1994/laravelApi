<?php

namespace App\Http\Controllers;
use App\MemberTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MemberTreeController extends Controller
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
        $data = MemberTree::all();
        return response($data);
    }
    public function show($id){
        $data = MemberTree::where('id',$id)->get();
        return response ($data);
    }
    public function showmember(Request $request, $member_id){
         $data = DB::table('member AS m')
                    ->join('member_tree AS mt', 'm.member_id', '=', 'mt.member_id')
                    ->select('m.member_id', 'm.nama', 'mt.pvpribadi')
                    ->where('m.member_id', '=', $member_id)
                            //select('m.member_id', 'm.nama', 'mt.pvpribadi', 'FROM', 'member', 'AS', 'm', 'member_tree', 'AS', 'mt', 'WHERE', 'm.member_id', '=', 'mt.member_id', 'AND', 'm.member_id', '=', 'm.member_id', $member_id)
                            // select('m.member_id', 'm.nama', 'mt.pvpribadi')
                            // ->from('member m', 'member_tree mt')
                            // ->where('m.member_id', '=', 'mt.member_id')
                            // ->where('AND', 'm.member_id', '=', 'm.member_id', $member_id)
                            ->get();
                            //SELECT m.member_id, m.nama, mt.pvpribadi FROM member m, member_tree mt WHERE m.member_id = mt.member_id AND m.member_id = m.member_id 
        return response ($data);
        print_r($data);
    }

    public function store (Request $request){
        $data = new MemberTree();
        $data->activity = $request->input('activity');
        $data->description = $request->input('description');
        $data->save();
    
        return response('Berhasil Tambah Data');
    }

    public function update(Request $request, $id)
    {
        $data = MemberTree::find($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Successfull update MemberTree'
        ]);
    }

    public function delete($id)
    {
        MemberTree::destroy($id);

        return response()->json([
            'message' => 'Successfull delete MemberTree'
        ]);
    }
}
