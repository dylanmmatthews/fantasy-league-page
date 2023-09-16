<?php

namespace App\Http\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * Title
 */
class Title extends Component
{
    /**
     * league
     *
     * @var mixed
     */
    public $league;

    /**
     * render
     *
     * @return Factory
     */
    public function render(): Factory|View
    {
        return view('livewire.title');
    }
}
