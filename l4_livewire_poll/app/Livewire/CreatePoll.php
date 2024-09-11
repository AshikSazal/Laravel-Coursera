<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Component;

class CreatePoll extends Component
{
    public $title;
    public $options = ['First'];
    protected $rules=[
        'title'=>'required|min:3|max:255',
        'options'=>'required|array|min:1|max:10',
        // this means all element inside the options array
        'options.*'=>'required|min:1|max:255'
    ];
    protected $messages = [
        'options.*'=>'The option can\'t be empty'
    ];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        // this should be done because of unset a particular index will not be a continous index. 
        // That particular index will be empty so I need to reinitialize to continue the index.
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate();
        // Both work same

        // 1.
        // $poll = Poll::create([
        //     'title'=>$this->title
        // ]);

        // foreach($this->options as $optionsName){
        //     $poll->options()->create(['name'=>$optionsName]);
        // }

        // 2.
        Poll::create([
            'title'=>$this->title
        ])->options()->createMany(
            collect($this->options)
            ->map(fn($option)=>['name'=>$option])
            // this will return the final array
            ->all()
        );
        // Reset the input field
        $this->reset(['title','options']);

        // this listener is created in Polls model in Livewire in $listener variable
        $this->emit('pollCreated');
    }

    // This mount method will only be called once and it won't be called on subsequent rerenders of this component
    // public function mount()
    // {

    // }
}
