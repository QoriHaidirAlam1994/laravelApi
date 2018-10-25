<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberTree extends Model
{
    public function member()
    {
        return $this->hasMany(Member::class);
    }

   protected $table = 'member_tree'; //nama table yang kita buat lewat migration adalah todo
}
