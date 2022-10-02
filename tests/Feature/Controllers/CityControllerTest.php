<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\CityIframe;
use App\Models\City;
use App\Models\Country;
use App\Models\Residence;
use App\Models\User;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_city_can_be_stored()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        $data = [
            'name' => 'Marrakech',
            'order' => 1,
            'active' => $country->is_active,
        ];

        $this->post(route('admin.cities.create', ['country' => $country]), $data);

        $this->assertDatabaseHas('cities', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_city_is_added()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        $this->assertEquals(
            CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($country->id),
            $this->post(
                route('admin.cities.create', ['country' => $country]),
                ['name' => 'Marrakech', 'order' => 1, 'active' => $country->is_active]
            )->content()
        );
    }

    public function test_if_city_can_be_updated()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $data = [
            'name' => 'Marrakech',
            'order' => 2,
            'active' => $city->country->is_active,
        ];

        $this->patch(route('admin.cities.city.edit', ['city' => $city]), $data);

        $this->assertDatabaseHas('cities', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_city_is_updated()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->assertEquals(
            CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($city->country_id),
            $this->patch(
                route('admin.cities.city.edit', ['city' => $city]),
                ['name' => 'Marrakech', 'order' => 2, 'active' => $city->country->is_active]
            )->content()
        );
    }

    public function test_if_city_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->delete(route('admin.cities.city.delete', ['city' => $city]));

        $this->assertDatabaseMissing('countries', $city->toArray());
    }

    public function test_if_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_city_is_destroyed()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->assertEquals(
            CityIframe::hideIframeD() . '<br>' . CityIframe::reloadParent($city->country_id),
            $this->delete(route('admin.cities.city.delete', ['city' => $city]))->content()
        );
    }

    public function test_that_city_cannot_be_destroyed_if_it_has_linked_residences()
    {
        $this->actingAsAdmin();

        $city = Residence::factory()->create()->city;

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked residences!",
                'failure',
                CityIframe::$iframeDId,
            ),
            $this->delete(route('admin.cities.city.delete', ['city' => $city]))->content()
        );
    }

    public function test_that_city_cannot_be_destroyed_if_it_has_linked_users()
    {
        $this->actingAsAdmin();

        $city = User::factory()->create()->city;

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked users!",
                'failure',
                CityIframe::$iframeDId,
            ),
            $this->delete(route('admin.cities.city.delete', ['city' => $city]))->content()
        );
    }

    public function test_get_cities_as_json()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        City::factory(1)->create(['country_id' => $country->id]);

        $this->assertEquals(
            $country->cities()->orderBy('order_by')->get(['id', 'name'])->toJson(),
            $this->post(route('admin.cities.get'), ['country_id' => $country->id])->content()
        );
    }

    public function test_get_only_active_cities_as_json()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->active()->create();

        City::factory()->inActive()->create(['country_id' => $country]);

        City::factory()->active()->create(['country_id' => $country]);

        $this->assertEquals(
            $country->cities()->active()->orderBy('order_by')->get(['id', 'name']),
            $this->post(route('cities.get'), ['country_id' => $country->id])->content()
        );
    }

    public function test_that_city_cannot_be_stored_or_updated_with_an_existing_name_for_the_same_county()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();
        $countryId = $city->country->id;

        $this->post(route('admin.cities.create', ['country' => $countryId]), [
            'name' => $city->name,
            'order' => $city->order_by,
        ])->assertInvalid(['name']);

        $this->patch(route('admin.cities.city.edit', ['city' => $city]), [
            'name' => City::factory()->create(['country_id' => $countryId])->name,
            'order' => $city->order_by,
        ])->assertInvalid(['name']);
    }

    public function test_that_name_and_order_fields_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [])
            ->assertInvalid(['name', 'order']);
        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [])
            ->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);

        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);
    }

    public function test_that_order_field_should_be_an_int()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);

        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);
    }
}
