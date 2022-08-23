<?php

namespace App\Http\Controllers;

use App\Iframes\OrderIframe;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('home.orders.index', [
            'orders' => Order::withSum('priceDetails', 'price')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('home.orders.create');
    }

    public function store(Request $request)
    {
        $order = Order::create($this->validateOrder($request));

        OrderService::processPrice($order, true);

        return
            OrderIframe::iframeCUClose()
            . '<br>' .
            OrderIframe::reloadParent();
    }

    public function edit(Order $order)
    {
        return view('home.orders.edit', [
            'order' => $order,
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($this->validateOrder($request));

        OrderService::processPrice($order);

        return
            OrderIframe::iframeCUClose()
            . '<br>' .
            OrderIframe::reloadParent();
    }

    public function validateOrder(Request $request)
    {
        $attributes = $request->validate([
            'from' => 'required|date',
            'to' => 'required|after:from',
            'for' => 'required|int',
            'country' => 'required|exists:countries,id',
            'city' => 'required|exists:cities,id',
            'residence' => 'required|exists:residences,id',
            'housing' => 'required|exists:housings,id',
            'formula' => 'required|exists:housing_formulas,id',
        ]);

        return [
            'residence_id' => $attributes['residence'],
            'housing_id' => $attributes['housing'],
            'housing_formula_id' => $attributes['formula'],
            'date_from' => $attributes['from'],
            'date_to' => $attributes['to'],
            'for_count' => $attributes['for'],
        ];
    }
}
