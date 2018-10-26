<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
/**
 * Model LogBonus
 */
class LogBonus extends Model
{
  /**
   * Table database
   */

  public function member()
    {
        return $this->hasMany(Member::class);
    }
    
  protected $table = 'log_bonus_a';
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  // protected $fillable = [
  //   'id','member_id','from_member','month(tanggal)','tgl_bonus','sum(amount)','jenis_bonus',
  // ];
  /**
   * One to one relationships
   */
}