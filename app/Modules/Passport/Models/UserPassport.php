<?php 
namespace App\Modules\Passport\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPassport extends Authenticatable {

	protected $table = 'user_passports';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'socialite_type', 'socialite_id','password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public static function getInstance()
    {
    	return new UserPassport();
    }

    public function scopeId($query,$id)
    {
        return $query->where('id', '=', $id);
    }    

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);  
    }

    public function scopeSocialiteType($query,$socialiteType)
    {
        return $query->where('socialite_type', '=', $socialiteType);
    }

    public function scopeSocialiteId($query,$socialiteId)
    {
        return $query->where('socialite_id', '=', $socialiteId);
    }

    public function scopeIdAsc($query)
    {
        return $query->orderBy('id', 'asc');
    }

    public function scopeIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }
}

?>