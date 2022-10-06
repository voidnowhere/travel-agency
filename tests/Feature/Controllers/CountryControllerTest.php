<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\CityIframe;
use App\Iframes\CountryIframe;
use App\Models\City;
use App\Models\Country;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CountryControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_country_can_be_stored()
    {
        $this->actingAsAdmin();

        $data = [
            'name' => 'Morocco',
            'order' => 1,
            'active' => true,
        ];

        $this->post(route('admin.countries.create'), $data)->assertOk();

        $this->assertDatabaseHas('countries', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_county_in_parent_iframe_is_focused_and_parent_iframe_and_cities_iframe_are_reloaded_after_country_is_stored()
    {
        $this->actingAsAdmin();

        $data = ['name' => 'Morocco', 'order' => 1];

        $response = $this->post(route('admin.countries.create'), $data);
        $response->assertOk();

        $countryId = Country::where('name', '=', $data['name'])->firstOrFail()->id;

        $this->assertEquals(
            CountryIframe::iframeCUClose() . '<br>' . CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($countryId) . '<br>' . CityIframe::reloadParent($countryId),
            $response->content()
        );
    }

    public function test_if_country_can_be_updated()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->inActive()->create();

        $data = [
            'name' => 'Morocco',
            'order' => 2,
            'active' => true,
        ];

        $this->patch(route('admin.countries.country.edit', ['country' => $country]), $data)->assertOk();

        $this->assertDatabaseHas('countries', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_county_in_parent_iframe_is_focused_and_parent_iframe_and_cities_iframe_are_reloaded_after_country_is_updated()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        $response = $this->patch(
            route('admin.countries.country.edit', ['country' => $country]), ['name' => 'Morocco', 'order' => 2]
        );
        $response->assertOk();

        $this->assertEquals(
            CountryIframe::iframeCUClose() . '<br>' . CountryIframe::reloadParent()
            . '<br>' .
            CountryIframe::parentFocusRow($country->id) . '<br>' . CityIframe::reloadParent($country->id),
            $response->content()
        );
    }

    public function test_if_country_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        $response = $this->delete(route('admin.countries.country.delete', ['country' => $country]));
        $response->assertOk();

        $this->assertEquals(
            CountryIframe::hideIframeD() . '<br>' . CityIframe::unloadParent() . '<br>' . CountryIframe::reloadParent(),
            $response->content()
        );

        $this->assertDatabaseMissing('countries', $country->toArray());
    }

    public function test_if_delete_iframe_is_hidden_and_cities_iframe_is_unloaded_and_parent_iframe_is_reloaded_after_country_is_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(route('admin.countries.country.delete', ['country' => Country::factory()->create()]));
        $response->assertOk();

        $this->assertEquals(
            CountryIframe::hideIframeD() . '<br>' . CityIframe::unloadParent() . '<br>' . CountryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_country_cannot_be_destroyed_if_it_has_liked_cities()
    {
        $this->actingAsAdmin();

        $country = City::factory()->create()->country;

        $response = $this->delete(route('admin.countries.country.delete', ['country' => $country]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $country->name country it has linked cities!",
                'failure',
                CountryIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_that_country_cannot_be_stored_or_updated_with_an_existing_name()
    {
        $this->actingAsAdmin();

        $country = Country::factory()->create();

        $this->post(route('admin.countries.create'), [
            'name' => $country->name,
            'order' => $country->order_by,
        ])->assertInvalid(['name']);

        $this->patch(route('admin.countries.country.edit', ['country' => $country]), [
            'name' => Country::factory()->create()->name,
            'order' => $country->order_by,
        ])->assertInvalid(['name']);
    }

    public function test_that_name_and_order_fields_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.countries.create'), [])->assertInvalid(['name', 'order']);
        $this->patch(route('admin.countries.country.edit', ['country' => Country::factory()->create()]), [])
            ->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.countries.create'), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);

        $this->patch(route('admin.countries.country.edit', ['country' => Country::factory()->create()]), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);
    }

    public function test_that_order_field_should_be_an_int()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.countries.create'), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);

        $this->patch(route('admin.countries.country.edit', ['country' => Country::factory()->create()]), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);
    }
}
