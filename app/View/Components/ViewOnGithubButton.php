<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ViewOnGithubButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $url, public string $containingClass = '', public string $iconType = 'dark') {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.view-on-github-button', [
            'url' => $this->url,
            'class' => $this->containingClass,
            'iconType' => $this->iconType,
        ]);
    }
}
