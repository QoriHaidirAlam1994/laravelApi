<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Member;
use App\MemberTree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class MemberController extends Controller
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
        $data = Member::all();
        return response($data);
    }
    public function show($id){
        $data = Member::where('id',$id)->get();
        return response ($data);
    }
    public function store (Request $request){
        $data = new Member();
        $data->member_id = $request->input('member_id');
        $data->password = md5('password');
        $data->nama = $request->input('nama');
        $data->save();

        $member_tree = new MemberTree();
        $member_id = Auth::user()->getAttributes()['member_id'];
        $member_tree->member_id = $data->member_id;
        $member_tree->upline_id = $member_id;
        $member_tree->save();
    
        return response()->json([
            'success' => 'Berhasil Tambah Data',
            'data' => $data,
            'member_tree' => $member_tree
            ]);
    }
    public function update(Request $request, $id)
    {
        $data = Member::find($id);
        $data->update($request->all());

        return response()->json([
            'message' => 'Successfull poto member'
        ]);
    }

    public function updatephoto(Request $request)
        {
            $member = new Member();

            $file = $request->file('photo');
            dd($file);
            $filename = $file->getClientOriginalName();
            $request->file('photo')->move('/public/upload', $filename);
            
            $member->photo = $filename;
            $member->save();
            
            $res['success'] = true;
            $res['message'] = "Success update foto member.";
            $res['data'] = $member;


        }
        

    public function delete($id)
    {
        Member::destroy($id);

        return response()->json([
            'message' => 'Successfull delete member'
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
