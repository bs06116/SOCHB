<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Post;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Showposts extends Component
{
    //public $readyToLoad = false;
    public $perPage = 15;
    public $search = '';
    public $posts;
    protected $listeners = [
        'load-more' => 'loadPosts',
        'filterItems' => 'filterItems',


    ];
    public function mount(){
        $this->posts = Post::with(['user','like'])->orderBy('id', 'DESC')->get();
    }
    public function loadPosts()
    {
       // $this->readyToLoad = true;
        $this->perPage = $this->perPage + 15;

    }
    public function render()
    {
        return view('livewire.showposts');
    }
    public function updated()
    {

        $this->emit('filterItems',(string) $this->search);
    }
    public function filterItems(string $search)
    {
        $this->posts = Post::with(['user','like'])->where('post_title', 'like', '%'.$search.'%')->orderBy('id', 'DESC')->get();

    }
    public function postTotalLike($post_id)
    {
        $this->totalLike = DB::table('posts_like')->where('post_id', $post_id)->count();
    }

}
