<?php 
namespace App\Modules\User\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInfo extends Model {

 	use SoftDeletes;
	protected $table = 'user_infos';
	protected $fillable = array('user_passport_id', 'name', 'avatar', 'gender', 'reward', 'post_count', 'praise_count', 'reply_count');

    public static function getInstance()
    {
    	return new UserInfo();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,array $ids)
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeUserPassportId($query,$userPassportId)
    {
        return $query->where('user_passport_id', '=', $userPassportId);
    }

    public function scopeUserPassportIds($query,array $userPassportIds)
    {
        return $query->whereIn('user_passport_id', $userPassportIds);
    }

    public function scopeName($query,$name)
    {
        return $query->where('name', 'like', '%'.$name."%");
    }

    public function scopeEqualName($query,$name)
    {
        return $query->where('name', '=', $name);
    }

}

?>