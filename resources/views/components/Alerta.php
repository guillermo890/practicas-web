<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alerta extends Component
{
    public $tipo;

    public function __construct($tipo = 'success')
    {
        $this->tipo = $tipo;
    }

    public function render(): View
    {
        return view('components.alerta');
    }
}