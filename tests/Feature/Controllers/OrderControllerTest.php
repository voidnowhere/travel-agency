<?php

namespace Tests\Feature\Controllers;

use App\Iframes\OrderIframe;
use App\Models\Housing;
use App\Models\HousingFormula;
use App\Models\Order;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_order_can_be_stored()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertOk();

        $this->assertDatabaseHas('orders', [
            'user_id' => $order->user_id,
            'housing_id' => $order->housing_id,
            'housing_formula_id' => $order->housing_formula_id,
            'date_from' => $order->date_from,
            'date_to' => $order->date_to,
            'for_count' => $order->for_count,
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_order_is_stored()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $response = $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ]);
        $response->assertOk();

        $this->assertEquals(
            OrderIframe::iframeCUClose() . '<br>' . OrderIframe::reloadParent($order->user_id),
            $response->content()
        );
    }

    public function test_if_order_can_be_updated()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertOk();

        $this->assertDatabaseHas('orders', [
            'housing_id' => $order->housing_id,
            'housing_formula_id' => $order->housing_formula_id,
            'date_from' => $order->date_from,
            'date_to' => $order->date_to,
            'for_count' => $order->for_count,
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_order_is_updated()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $newOrder = Order::factory()->create();
        $response = $this->patch(route('admin.orders.order.edit', ['order' => $newOrder]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ]);
        $response->assertOk();

        $this->assertEquals(
            OrderIframe::iframeCUClose() . '<br>' . OrderIframe::reloadParent($newOrder->user_id),
            $response->content()
        );
    }

    public function test_that_all_fields_are_required_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.orders.create', ['user' => User::factory()->create()]), [])->assertInvalid([
            'from', 'to', 'for', 'housing', 'formula'
        ]);
    }

    public function test_that_all_fields_are_required_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [])->assertInvalid([
            'from', 'to', 'for', 'housing', 'formula'
        ]);
    }

    public function test_that_from_field_should_be_a_date_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => 'test',
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['from']);
    }

    public function test_that_from_field_should_be_a_date_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => 'test',
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['from']);
    }

    public function test_that_to_field_should_be_a_date_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => 'test',
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['to']);
    }

    public function test_that_to_field_should_be_a_date_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from,
            'to' => 'test',
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['to']);
    }

    public function test_that_to_field_should_be_after_from_field_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from->addDay(),
            'to' => $order->date_from,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['to']);
    }

    public function test_that_to_field_should_be_after_from_field_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from->addDay(),
            'to' => $order->date_from,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['to']);
    }

    public function test_that_for_field_should_be_an_int_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => 'test',
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['for']);
    }

    public function test_that_for_field_should_be_an_int_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => 'test',
            'housing' => $order->housing_id,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['for']);
    }

    public function test_that_housing_field_should_exists_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => Housing::max('id') + 1,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['housing']);
    }

    public function test_that_housing_field_should_exists_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => Housing::max('id') + 1,
            'formula' => $order->housing_formula_id,
        ])->assertInvalid(['housing']);
    }

    public function test_that_formula_field_should_exists_when_storing_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->post(route('admin.orders.create', ['user' => $order->user_id]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => HousingFormula::max('id') + 1,
        ])->assertInvalid(['formula']);
    }

    public function test_that_formula_field_should_exists_when_updating_an_order()
    {
        $this->actingAsAdmin();

        $order = Order::factory()->create();
        $order->delete();

        $this->patch(route('admin.orders.order.edit', ['order' => Order::factory()->create()]), [
            'from' => $order->date_from,
            'to' => $order->date_to,
            'for' => $order->for_count,
            'housing' => $order->housing_id,
            'formula' => HousingFormula::max('id') + 1,
        ])->assertInvalid(['formula']);
    }
}
