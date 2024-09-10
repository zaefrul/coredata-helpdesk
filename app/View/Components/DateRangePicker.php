<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DateRangePicker extends Component
{
    public $label;
    public $startDate;
    public $endDate;
    public $errorStartDate;
    public $errorEndDate;
    public $required;
    /**
     * Create a new component instance.
     */
    public function __construct($label = 'Date Range', $startDate = null, $endDate = null, $required = false, $errorStartDate = null, $errorEndDate = null)
    {
        $this->label = $label;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->required = $required;
        $this->errorStartDate = $errorStartDate;
        $this->errorEndDate = $errorEndDate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.date-range-picker');
    }
}
