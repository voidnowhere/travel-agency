<?php

namespace App\Http\Controllers;

use App\Iframes\OrderIframe;
use App\Models\Order;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(User $user)
    {
        return view('admin.orders.index', [
            'user_id' => $user->id,
            'orders' => $user->orders()
                ->latest()
                ->withSum('priceDetails', 'price')
                ->with(['statusDetails:order_id,description', 'housing:id,residence_id,name,for_max', 'housing.residence:id,name', 'formula:id,name'])
                ->get(['id', 'housing_id', 'housing_formula_id', 'date_from', 'date_to', 'for_count', 'status']),
        ]);
    }

    public function details(Order $order)
    {
        return view('admin.orders.details', [
            'priceDetails' => $order->priceDetails()->get(['type', 'date_from', 'date_to', 'price'])
        ]);
    }

    public function create()
    {
        return view('home.orders.create');
    }

    public function store(Request $request, User $user)
    {
        $order = $user->orders()->create($this->validateOrder($request));

        OrderService::processPrice($order);

        return OrderIframe::iframeCUClose() . '<br>' . OrderIframe::reloadParent($user->id);
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

        return OrderIframe::iframeCUClose() . '<br>' . OrderIframe::reloadParent($order->user_id);
    }

    protected function validateOrder(Request $request)
    {
        $attributes = $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'for' => 'required|int',
            'housing' => 'required|exists:housings,id',
            'formula' => 'required|exists:housing_formulas,id',
        ]);

        return [
            'housing_id' => $attributes['housing'],
            'housing_formula_id' => $attributes['formula'],
            'date_from' => $attributes['from'],
            'date_to' => $attributes['to'],
            'for_count' => $attributes['for'],
        ];
    }
}
