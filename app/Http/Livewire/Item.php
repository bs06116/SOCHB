<?php
namespace App\Http\Livewire;
use Livewire\Component;
use App\Post as MidadPost;
use App\Like;
use Auth;
use DB;

class Item extends Component
{
    public $post,$postId;

    // protected $listeners = [
    //     'itemRemoved' => 'removeRowId',
    //     'cartDestroyed' => 'updated',
    // ];

    public function mount(MidadPost $post)
    {
        $this->post = $post;
    }

    public function render()
    {
       $getUserLike = DB::table('posts_like')->where('post_id', $this->post->id)->where('user_id', Auth::id())->first();
        if ($getUserLike) {
            $this->postId = $this->post->id;
        } else{
            $this->postId = null;
        }
        return view('livewire.item');
    }
    public function like($post_id)
    {
        if (!auth()->check()) {
            return abort('403'); // or you can return the user to the login page
        }
        $like = new Like();
        $like->post_id = $post_id;
        $like->user_id = Auth::id();
        $like->save();
        $this->postId = $post_id;
        //$this->postTotalLike($post_id);
    }

    public function dislike($post_id)
    {
        DB::table('posts_like')->where('post_id', $post_id)->where('user_id', Auth::id())->delete();
        $this->postId = null;
        //$this->postTotalLike($post_id);
    }

}
