<?php 
namespace App\Modules\Ad\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model {

 	use SoftDeletes;
	protected $table = 'ads';
	protected $fillable = array('location','title','description','image','url','weight');

    public static function getInstance()
    {
    	return new Ad();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
    	return $query->whereIn('id', $ids);    	
    }

    public function scopeLocation($query,$location)
    {
        return $query->where('location', '=', $location);
    }

    public function scopeIdAsc($query)
    {
        return $query->orderBy('id', 'asc');
    }

    public function scopeIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeWeightAsc($query)
    {
        return $query->orderBy('weight', 'asc');
    }

    public function scopeWeightDesc($query)
    {
        return $query->orderBy('weight', 'desc');
    }
}

?>