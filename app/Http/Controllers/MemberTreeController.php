<?php

namespace App\Http\Controllers;
use Auth;
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
    public function __construct(Request $request)
    {
        $this->middleware('auth',['except'=>[]]);

    }
    public function index(){
        $data = MemberTree::all();
        return response($data);
    }
    public function show($id){
        $data = MemberTree::where('id',$id)->get();
        return response ($data);
    }
    public function showmember(Request $request){
        $member_id = Auth::user()->getAttributes()['member_id'];
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
        $member_id = Auth::user()->getAttributes()['member_id'];
        $data->member_id = $request->input('member_id');
        $data->upline_id = $member_id;
        $data->save();
    
        return response()->json(['message' => 'Berhasil Tambah Data',
                                'data' => $data
        ]);
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
