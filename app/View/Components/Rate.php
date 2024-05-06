<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Rate extends Component
{
    public string $rating;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $rate,
        public int $total = 5,
        public string $empty = '☆',
        public string $filled = '★',
    ) {
        $this->rating = str_repeat($this->filled, $this->rate) . mb_substr(str_repeat($this->empty, $this->total), $this->rate);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.rate');
    }
}
