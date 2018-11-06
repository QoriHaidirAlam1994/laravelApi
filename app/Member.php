<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    public function membertree()
    {
        return $this->belongsTo(MemberTree::class);
    }

    public function logbonus()
    {
        return $this->belongsTo(LogBonus::class);
    }


   protected $table = 'member'; //nama table yang kita buat lewat migration adalah todo

   protected $fillable = [
    'photo',
];
}