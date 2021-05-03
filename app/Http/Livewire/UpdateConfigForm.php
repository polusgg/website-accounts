<?php

namespace App\Http\Livewire;

use App\Actions\UpdateUserConfigInformation;
use Livewire\Component;

class UpdateConfigForm extends Component
{
    public array $state = [];

    public function mount()
    {
        $this->state = $this->user->gamePerkConfig->toArray();
        $this->state['name_color'] = $this->state['name_color_match_enabled'] ? "match"
                                   : ($this->state['name_color_gold_enabled'] ? "gold"
                                   : "normal");
    }

    public function updateConfig(UpdateUserConfigInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user()->gamePerkConfig, $this->state);

        $this->emit('saved');
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('profile.update-config-form');
    }
}
