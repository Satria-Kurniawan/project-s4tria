<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Rider;

class Riders extends Component
{
    public $search;
    public $riders;
    public $riderId, $number, $image, $name, $team;
    public $isOpen = 0;
    public $deleteOpen = 0;

    public function render()
    {
        // $this->riders = Rider::all();
        $searchParams = '%'.$this->search.'%';
        $this->riders = Rider::where('name', 'like', $searchParams)
                            ->orWhere('number', 'like', $searchParams)
                            ->orWhere('team', 'like', $searchParams)->get();

        return view('livewire.riders');
    }

    public function showRiderModal(){
        $this->isOpen = true;
    }

    public function hideRiderModal(){
        $this->isOpen = false;
    }

    public function delShowRiderModal(){
        $this->deleteOpen = true;
    }

    public function delHideRiderModal(){
        $this->deleteOpen = false;
    }

    public function store(){
        $this->validate(
            [
                'number' => 'required',
                // 'image' => 'required',
                'name' => 'required',
                'team' => 'required',
            ]
        );

        Rider::updateOrCreate(['id' => $this->riderId], [
            'number' => $this->number,
            'image' => $this->image,
            'name' => $this->name,
            'team' => $this->team,
        ]);

        $this->hideRiderModal();

        session()->flash('message', $this->riderId ? 'Updated Successfully' : 'Created Successfully');

        $this->riderId = '';
        $this->number = '';
        $this->image = '';
        $this->name = '';
        $this->team = '';
    }

    public function edit($id){
        $rider = Rider::findOrFail($id);

        $this->riderId = $id;
        $this->number = $rider->number;
        $this->image = $rider->image;
        $this->name = $rider->name;
        $this->team = $rider->team;

        $this->showRiderModal();
    }

    public function delete($id){
        Rider::find($id)->delete();
        $this->delHideRiderModal();
        session()->flash('deletemessage', 'Deleted Successfully');
    }
}
