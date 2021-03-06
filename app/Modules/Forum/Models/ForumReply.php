<?php 
namespace App\Modules\Forum\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumReply extends Model {

 	use SoftDeletes;
	protected $table = 'forum_replies';
	protected $fillable = array('user_passport_id', 'forum_post_id', 'content');

    public static function getInstance()
    {
    	return new ForumReply();
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

    public function scopeForumPostId($query,$forumPostId)
    {
        return $query->where('forum_post_id', '=', $forumPostId);
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