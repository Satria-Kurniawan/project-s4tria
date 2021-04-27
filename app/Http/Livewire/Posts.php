<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;
use App\Models\Rider;

class Posts extends Component
{
    public $search;
    public $posts;
    public $postId, $point, $name, $ranking, $team;
    public $isOpen = 0;
    public $deleteOpen = 0;

    public function render()
    {
        $rd = Rider::all();
        $this->posts = Post::with('rider');
        // $this->posts = Post::all();
        $searchParams = '%'.$this->search.'%';
        $this->posts = Post::where('name', 'like', $searchParams)
                            ->orWhere('point', 'like', $searchParams)->get();

        return view('livewire.posts', compact('rd'));
    }

    public function showModal(){
        $this->isOpen = true;
    }

    public function hideModal(){
        $this->isOpen = false;
    }

    public function delShowModal(){
        $this->deleteOpen = true;
    }

    public function delHideModal(){
        $this->deleteOpen = false;
    }

    public function store(){
        $this->validate(
            [
                'team' => 'required',
                'point' => 'required',
                'name' => 'required',
                'ranking' => 'required',
            ]
        );

        Post::updateOrCreate(['id' => $this->postId], [
            'team_id' => $this->team,
            'point' => $this->point,
            'name' => $this->name,
            'ranking' => $this->ranking,
        ]);

        $this->hideModal();

        session()->flash('message', $this->postId ? 'Updated Successfully' : 'Created Successfully');

        $this->postId = '';
        $this->team = '';
        $this->point = '';
        $this->name = '';
        $this->ranking = '';
    }

    public function edit($id){
        $post = Post::findOrFail($id);
        $this->postId = $id;
        $this->team = $post->team;
        $this->point = $post->point;
        $this->name = $post->name;
        $this->ranking = $post->ranking;

        $this->showModal();
    }

    public function delete($id){
        Post::find($id)->delete();
        $this->delHideModal();
        session()->flash('deletemessage', 'Deleted Successfully');
    }
}
