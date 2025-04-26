<?php

namespace App\Http\Livewire;

use App\Models\Item;
use Livewire\Component;

class Search extends Component
{
    public $search="";

    public $results=[];

    public function render()
    {
        if(strlen($this->search) >= 1){
            $this->results=Item::where(function ($query) {
                $query->where('item_name','like','%'.$this->search.'%');
            })->get();
        }
        return view('livewire.search');
    }
}
