<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GithubProjectTable extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $table, public int $boardId)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.github-project-table', [
            'table' => $this->table,
            'boardId' => $this->boardId,
        ]);
    }
}
