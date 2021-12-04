<?php

namespace App\Http\Livewire;

use App\Models\ContactSchedule;
use Livewire\Component;
use App\Models\Schedule;

class EditSchedule extends Component
{
    public $schedule;
    public $action;
    public $selectedItem;

    protected $listeners = [
        'refreshParent' => '$refresh'
    ];

    public function selectItem($itemId, $action)
    {
        $this->selectedItem = $itemId;
        
        if ($action == 'delete') {
            // This will show the modal on the frontend
            $this->dispatchBrowserEvent('openDeleteModal');
        } elseif ($action == 'showPhotos') {
            // Pass the currently selected item
            $this->emit('getPostId', $this->selectedItem);

            // Show the modal that shows the additional photos
            $this->dispatchBrowserEvent('openModalShowPhotos');
        }
        else {
            $this->emit('getModelId', $this->selectedItem);
            $this->dispatchBrowserEvent('openModal');
        }
    }

    public function delete()
    {

        ContactSchedule::findOrFail($this->selectedItem)->delete();
        $this->emit('refreshParent');

        // Schedule::destroy();
        $this->dispatchBrowserEvent('closeDeleteModal');

    }

  
    public function render()
    {
        return view('livewire.edit-schedule');
    }
}
