<?php 
namespace App\Modules\Article\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {

 	use SoftDeletes;
	protected $table = 'articles';
	protected $fillable = array('article_category_id', 'title', 'image', 'description', 'content', 'view_count', 'weight');

    public static function getInstance()
    {
    	return new Article();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);     
    }

    public function scopeArticleCategoryId($query,$articleCategoryId)
    {
        return $query->where('article_category_id', '=', $articleCategoryId);
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

    public function scopeRand($query)
    {
        return $query->orderByRaw("RAND()");
    }
}

?>