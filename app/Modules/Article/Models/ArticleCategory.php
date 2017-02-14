<?php 
namespace App\Modules\Article\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model {

 	use SoftDeletes;
	protected $table = 'article_categories';
	protected $fillable = array('name', 'weight');

    public static function getInstance()
    {
    	return new ArticleCategory();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);     
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