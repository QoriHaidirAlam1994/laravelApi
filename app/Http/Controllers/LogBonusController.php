<?php

namespace App\Http\Controllers;

use Auth;
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
    public function __construct(Request $request)
    {
        $this->middleware('auth',['except'=>[]]);

    }
    public function index(){
        $data = LogBonus::all();
        return response($data);
    }
    public function show($id){
        $data = LogBonus::where('id',$id)->get();
        return response ($data);
    }

    public function showmember($tanggal){
        $member_id = Auth::user()->getAttributes()['member_id'];
        $data =  DB::table('log_bonus_a as lb')
                    ->join('member as m', 'm.member_id', '=', 'lb.member_id')
                    ->select( 'm.nama', DB::raw('sum(lb.amount) as jumlah'), DB::raw('month(lb.tanggal) as bulan'))
                    ->where([[DB::raw('year(lb.tanggal)'), '=', $tanggal], ['m.member_id', '=', $member_id]])
                    ->groupBy(DB::raw('month(lb.tanggal)'))
                    ->get();
        $bonus = DB::table('log_bonus_a')->select(DB::raw('sum(amount) as jumlah'), DB::raw('month(tanggal) as bulan'))
                    ->where([[DB::raw('year(tanggal)'), '=', $tanggal], ['member_id', '=', $member_id]])
                    ->groupBy(DB::raw('month(tanggal)'))
                    ->get();
                    
                    if (sizeof($data) <= 0) {
                        $response =
                        [
                            'status' => 0,
                            'errors' => 'salah input'
                        ];
                        return response()->json($response, 400, [], JSON_PRETTY_PRINT)->send();
                        die;
                    }
                    $nama = $data[0]->nama;
                    return response()->json([
                        'member_id' => $member_id,
                        'nama' => $nama,
                        'bonus' => $bonus
                    ]);
                     
        // $data = DB::table('member AS m')
        // ->join('log_bonus_a AS mt', 'm.member_id', '=', 'mt.member_id')
        // ->select('m.member_id', 'm.nama', 'mt.amount', 'mt.tgl_bonus')
        // ->where([['m.member_id', '=', $member_id],['mt.tgl_bonus', '=', $tgl_bonus]])
        // ->get();
        // return response ($data);

    }
    
    public function store (Request $request){
        // $data = DB::table('log_bonus_a')->insert('member_id', 'from_member', 'tanggal', 'tgl_bonus', 'amount', 'jenis_bonus')
        //             ->get();
        $data = new LogBonus();
        $member_id = Auth::user()->getAttributes()['member_id'];
        $data->member_id = $member_id;
        $data->from_member = $request->input('from_member');
        $data->tanggal = $request->input('tanggal');
        $data->tgl_bonus = $request->input('tgl_bonus');
        $data->amount = $request->input('amount');
        $data->jenis_bonus = $request->input('jenis_bonus');
        $data->save();
    
        return response()->json([
            'message' => 'success',
            'data' => $data
        ]);
    }
    public function update(Request $request, $id)
    {
        $data = LogBonus::find($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Successfull Bonus'
        ]);
    }

    public function delete($id)
    {
        Product::destroy($id);

        return response()->json([
            'message' => 'Successfull delete product'
        ]);
    }

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $response = [
                'status' => 0,
                'errors' => $validator->errors()
            ];


            if ($request->isMethod('OPTIONS'))
            {
                $headers = [
                    'Access-Control-Allow-Origin'      => '*',
                    'Access-Control-Allow-Methods'     => 'GET,POST,OPTIONS, PUT, DELETE',
                    'Access-Control-Allow-Credentials' => 'true',
                    'Access-Control-Max-Age'           => '86400',
                    // 'Access-Control-Allow-Headers'     => 'Content-Type, Authorization, X-Requested-With',
                    'Access-Control-Allow-Headers'     => '*',
                    'Content-Length'=>'0',
                    'Content-Type'=>'application/json'
                ];

                //return response()->json('{"method":"OPTIONS"}', 200, $headers);
                return response()->json(["method"=>"OPTIONS"], 200, $headers);


            }

            response()->json($response, 400, [], JSON_PRETTY_PRINT)
                ->header('Access-Control-Allow-Origin','*')
                ->header('Access-Control-Allow-Methods','POST, GET, OPTIONS, PUT, DELETE')
                ->header('Access-Control-Allow-Credentials','true')
                ->header('Access-Control-Max-Age','86400')
                ->header('Access-Control-Allow-Headers','*')
                ->send();
            die();

        }

        return true;
    }
}
