<?php

namespace App\View\Components\Seats;

use Illuminate\View\Component;

class Table extends Component
{
    public $seats;
    public $showView;
    public $showEdit;
    public $showDelete;
    public $showAddToCart;
    public $showRemoveFromCart;

    public function __construct(array $seats, $showView, $showEdit, $showDelete, $showAddToCart, $showRemoveFromCart)
    {
        $this->seats = $seats;
        $this->showView = $showView;
        $this->showEdit = $showEdit;
        $this->showDelete = $showDelete;
        $this->showAddToCart = $showAddToCart;
        $this->showRemoveFromCart = $showRemoveFromCart;
    }

    public function render()
    {
        return view('components.seats.table');
    }
}
