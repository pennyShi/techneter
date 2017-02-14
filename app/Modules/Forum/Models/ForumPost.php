<?php 
namespace App\Modules\Forum\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumPost extends Model {

 	use SoftDeletes;
	protected $table = 'forum_posts';
	protected $fillable = array('user_passport_id', 'forum_category_id', 'title', 'content', 'view_count', 'praise_count', 'reply_count', 'weight');

    public static function getInstance()
    {
    	return new ForumPost();
    }

    public function scopeId($query,$id)
    {
    	return $query->where('id', '=', $id);
    }

    public function scopeIds($query,$ids)
    {
        return $query->whereIn('id', $ids);     
    }

    public function scopeUserPassportId($query,$userPassportId)
    {
        return $query->where('user_passport_id', '=', $userPassportId);
    }

    public function scopeForumCategoryId($query,$forumCategoryId)
    {
        return $query->where('forum_category_id', '=', $forumCategoryId);
    }

    public function scopeIdAsc($query)
    {
        return $query->orderBy('id', 'asc');
    }

    public function scopeIdDesc($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function scopeViewCountAsc($query)
    {
        return $query->orderBy('view_count', 'asc');
    }

    public function scopeViewCountDesc($query)
    {
        return $query->orderBy('view_count', 'desc');
    }

    public function scopePraiseCountAsc($query)
    {
        return $query->orderBy('praise_count', 'asc');
    }

    public function scopePraiseCountDesc($query)
    {
        return $query->orderBy('praise_count', 'desc');
    }

    public function scopeReplyCountAsc($query)
    {
        return $query->orderBy('reply_count', 'asc');
    }

    public function scopeReplyCountDesc($query)
    {
        return $query->orderBy('reply_count', 'desc');
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