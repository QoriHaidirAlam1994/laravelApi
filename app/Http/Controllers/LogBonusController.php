<?php

namespace App\Http\Controllers;
use App\LogBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LogBonusController extends Controller
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
        $data = LogBonus::all();
        return response($data);
    }
    public function show($id){
        $data = LogBonus::where('id',$id)->get();
        return response ($data);
    }

    public function showmember($member_id, $tgl_bonus){
        $data = DB::table('member AS m')
        ->join('log_bonus_a AS mt', 'm.member_id', '=', 'mt.member_id')
        ->select('m.member_id', 'm.nama', 'mt.amount', 'mt.tgl_bonus')
        ->where([['m.member_id', '=', $member_id],['mt.tgl_bonus', '=', $tgl_bonus]])
        ->get();
        return response ($data);
    }
    
    
    public function store (Request $request){
        $data = new LogBonus();
        $data->activity = $request->input('activity');
        $data->description = $request->input('description');
        $data->save();
    
        return response('Berhasil Tambah Data');
    }
    public function update(Request $request, $id)
    {
        $data = Product::find($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Successfull update product'
        ]);
    }

    public function delete($id)
    {
        Product::destroy($id);

        return response()->json([
            'message' => 'Successfull delete product'
        ]);
    }
}
