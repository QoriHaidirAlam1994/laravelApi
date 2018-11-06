<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

use Illuminate\Support\Facades\Hash;

class MemberUser extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $table="member";

    public function membertree()
    {
        return $this->belongsTo(MemberTree::class);
    }

    public function logbonus()
    {
        return $this->belongsTo(LogBonus::class);
    }

    static public function rules($id=NULL)
    {
        return [
            'member_id' => 'required|unique:member,member_id,'.$id,
            'password' => 'required',
            'email' => 'required|email|unique:member,email,'.$id,
        ];
    }
    static public function updateRules($id=NULL)
    {
        return [
            'member_id' => 'required|unique:member,member_id,'.$id,
            'email' => 'required|email|unique:member,email,'.$id,
        ];
    }
    static public function authorizeRules()
    {
        return [
            'member_id' => 'required',
            'password' => 'required',
        ];
    }
    static public function accessTokenRules()
    {
        return [
            'authorization_code' => 'required',
        ];
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'member_id', 'email', 'password', 'name', 'created_at', 'updated_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'password_reset_token'
    ];
    static public function search($request)
    {

        $page = $request->input('page');
        $limit = $request->input('limit');
        $order = $request->input('order');

        $search = $request->input('search');

        if(isset($search)){
            $params=$search;
        }

        $limit = isset($limit) ? $limit : 10;
        $page = isset($page) ? $page : 1;


        $offset = ($page - 1) * $limit;

        $query = MemberUser::select(['id', 'member_id', 'email'])
            ->limit($limit)
            ->offset($offset);

        if(isset($params['id'])) {
            $query->where(['id' => $params['id']]);
        }

        if(isset($params['created_at'])) {
            $query->where(['created_at' => $params['created_at']]);
        }
        if(isset($params['updated_at'])) {
            $query->where(['updated_at' => $params['updated_at']]);
        }
        if(isset($params['member_id'])) {
            $query->where('member_id','like',$params['member_id']);
        }
        if(isset($params['email'])){
            $query->where('email','like',$params['email']);
        }


        if(isset($order)){
            $query->orderBy($order);
        }

        $data=$query->get();


        return [
            'status'=>1,
            'data' => $data,
            'page' => (int)$page,
            'size' => $limit,
            'totalCount' => (int)$data->count()
        ];
    }



    public static function authorize($attributes){

        $model=MemberUser::where(['member_id'=>$attributes['member_id']])->select(['id','member_id','password'])->first();
        if(!$model)
            return false;


       // if(Hash::check($attributes['password'],$model->password)) {
      if(md5($attributes['password'])==$model->password) {
            return $model;
            // Right password
        } else {
            // Wrong one
        }



        return false;
    }

    /*
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $access_token = AccessTokens::findOne(['token' => $token]);
        if ($access_token) {
            if ($access_token->expires_at < time()) {
                Yii::$app->api->sendFailedResponse('Access token expired');
            }

            return static::findOne(['id' => $access_token->user_id]);
        } else {
            return (false);
        }
        //throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }
    */
}
