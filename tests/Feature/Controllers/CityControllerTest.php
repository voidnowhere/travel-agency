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

        $countryId = Country::factory()->create()->id;

        $data = [
            'name' => 'Marrakech',
            'order' => 1,
            'active' => true,
        ];

        $this->post(route('admin.cities.create', ['country' => $countryId]), $data)->assertOk();

        $this->assertDatabaseHas('cities', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_city_is_added()
    {
        $this->actingAsAdmin();

        $countryId = Country::factory()->create()->id;

        $response = $this->post(
            route('admin.cities.create', ['country' => $countryId]),
            ['name' => 'Marrakech', 'order' => 1, 'active' => true]
        );
        $response->assertOk();

        $this->assertEquals(
            CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($countryId),
            $response->content()
        );
    }

    public function test_if_city_can_be_updated()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $data = [
            'name' => 'Marrakech',
            'order' => 2,
            'active' => false,
        ];

        $this->patch(route('admin.cities.city.edit', ['city' => $city]), $data)->assertOk();

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

        $response = $this->patch(
            route('admin.cities.city.edit', ['city' => $city]),
            ['name' => 'Marrakech', 'order' => 2, 'active' => true]
        );
        $response->assertOk();

        $this->assertEquals(
            CityIframe::iframeCUClose() . '<br>' . CityIframe::reloadParent($city->country_id),
            $response->content()
        );
    }

    public function test_if_city_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->delete(route('admin.cities.city.delete', ['city' => $city]))->assertOk();

        $this->assertDatabaseMissing('countries', $city->toArray());
    }

    public function test_if_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_city_is_destroyed()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $response = $this->delete(route('admin.cities.city.delete', ['city' => $city]));
        $response->assertOk();

        $this->assertEquals(
            CityIframe::hideIframeD() . '<br>' . CityIframe::reloadParent($city->country_id),
            $response->content()
        );
    }

    public function test_that_city_cannot_be_destroyed_if_it_has_linked_residences()
    {
        $this->actingAsAdmin();

        $city = Residence::factory()->create()->city;

        $response = $this->delete(route('admin.cities.city.delete', ['city' => $city]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked residences!",
                'failure',
                CityIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_that_city_cannot_be_destroyed_if_it_has_linked_users()
    {
        $this->actingAsAdmin();

        $city = User::factory()->create()->city;

        $response = $this->delete(route('admin.cities.city.delete', ['city' => $city]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $city->name city it has linked users!",
                'failure',
                CityIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_get_cities_as_json()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        City::factory(1)->create(['country_id' => $country->id]);

        $response = $this->post(route('admin.cities.get'), ['country_id' => $country->id]);
        $response->assertOk();

        $this->assertEquals(
            $country->cities()->orderBy('order_by')->get(['id', 'name'])->toJson(),
            $response->content()
        );
    }

    public function test_get_only_active_cities_as_json()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->active()->create();

        City::factory()->inActive()->create(['country_id' => $country]);

        City::factory()->active()->create(['country_id' => $country]);

        $response = $this->post(route('cities.get'), ['country_id' => $country->id]);
        $response->assertOk();

        $this->assertEquals(
            $country->cities()->active()->orderBy('order_by')->get(['id', 'name']),
            $response->content()
        );
    }

    public function test_that_get_only_active_cities_return_null_when_country_is_inactive()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->inActive()->create();

        City::factory()->inActive()->create(['country_id' => $country]);

        City::factory()->active()->create(['country_id' => $country]);

        $response = $this->post(route('cities.get'), ['country_id' => $country->id]);
        $response->assertOk();

        $this->assertEquals(null, $response->content());
    }

    public function test_that_city_cannot_be_stored_with_an_existing_name_for_the_same_county()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->post(route('admin.cities.create', ['country' => $city->country_id]), [
            'name' => $city->name,
            'order' => $city->order_by,
        ])->assertInvalid(['name']);
    }

    public function test_that_city_cannot_be_updated_with_an_existing_name_for_the_same_county()
    {
        $this->actingAsAdmin();

        $city = City::factory()->create();

        $this->patch(route('admin.cities.city.edit', ['city' => $city]), [
            'name' => City::factory()->create(['country_id' => $city->country_id])->name,
            'order' => $city->order_by,
        ])->assertInvalid(['name']);
    }

    public function test_that_name_and_order_fields_are_required_when_storing_a_city()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [])
            ->assertInvalid(['name', 'order']);
    }

    public function test_that_name_and_order_fields_are_required_when_updating_a_city()
    {
        $this->actingAsAdmin();

        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [])
            ->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha_when_storing_a_city()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);
    }

    public function test_that_name_field_should_be_an_alpha_when_updating_a_city()
    {
        $this->actingAsAdmin();

        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);
    }

    public function test_that_order_field_should_be_an_int_when_storing_a_city()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.cities.create', ['country' => Country::factory()->create()]), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);
    }

    public function test_that_order_field_should_be_an_int_when_updating_a_city()
    {
        $this->actingAsAdmin();

        $this->patch(route('admin.cities.city.edit', ['city' => City::factory()->create()]), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);
    }
}
