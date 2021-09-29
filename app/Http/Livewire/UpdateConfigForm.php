<?php

namespace App\Http\Livewire;

use App\Actions\UpdateUserConfigInformation;
use Livewire\Component;

class UpdateConfigForm extends Component
{
    public array $state = [];
    public string $game_language;

    public function mount()
    {
        $this->state = $this->user->gamePerkConfig->toArray();
        $this->state['name_color'] = $this->state['name_color_match_enabled'] ? "match"
                                   : ($this->state['name_color_gold_enabled'] ? "gold"
                                   : "normal");
        $this->game_language = $this->user->language;
    }

    public function updateConfig(UpdateUserConfigInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(auth()->user()->gamePerkConfig, $this->state);
        $updater->updateLanguage($this->user, $this->game_language);

        $this->emit('saved');
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('profile.update-config-form')->with('languages', config('languages'));
    }
}
