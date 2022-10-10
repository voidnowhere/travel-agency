<?php

namespace Tests\Feature\Controllers;

use App\Iframes\HousingPriceIframe;
use App\Models\Housing;
use App\Models\HousingFormula;
use App\Models\HousingPrice;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HousingPriceControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_housing_price_can_be_stored()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'extra_price_active' => $price->extra_price_is_active,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'weekend_active' => $price->weekend_is_active,
            'kid_bed_price' => $price->kid_bed_price,
            'kid_bed_active' => $price->kid_bed_is_active,
            'extra_bed_price' => $price->extra_bed_price,
            'extra_bed_active' => $price->extra_bed_is_active,
        ])->assertOk();

        $this->assertDatabaseHas('housing_prices', $price->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_price_is_stored()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $response = $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'extra_price_active' => $price->extra_price_is_active,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'weekend_active' => $price->weekend_is_active,
            'kid_bed_price' => $price->kid_bed_price,
            'kid_bed_active' => $price->kid_bed_is_active,
            'extra_bed_price' => $price->extra_bed_price,
            'extra_bed_active' => $price->extra_bed_is_active,
        ]);
        $response->assertOk();

        $this->assertEquals(
            HousingPriceIframe::iframeCUClose() . '<br>' . HousingPriceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_housing_price_can_be_updated()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'extra_price_active' => $price->extra_price_is_active,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'weekend_active' => $price->weekend_is_active,
            'kid_bed_price' => $price->kid_bed_price,
            'kid_bed_active' => $price->kid_bed_is_active,
            'extra_bed_price' => $price->extra_bed_price,
            'extra_bed_active' => $price->extra_bed_is_active,
        ])->assertOk();

        $this->assertDatabaseHas('housing_prices', $price->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_price_is_updated()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $response = $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'extra_price_active' => $price->extra_price_is_active,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'weekend_active' => $price->weekend_is_active,
            'kid_bed_price' => $price->kid_bed_price,
            'kid_bed_active' => $price->kid_bed_is_active,
            'extra_bed_price' => $price->extra_bed_price,
            'extra_bed_active' => $price->extra_bed_is_active,
        ]);
        $response->assertOk();

        $this->assertEquals(
            HousingPriceIframe::iframeCUClose() . '<br>' . HousingPriceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_housing_price_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();

        $this->delete(route('admin.housing.prices.price.delete', ['price' => $price]))->assertOk();

        $this->assertDatabaseMissing('housing_prices', $price->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_housing_price_is_destroyed()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();

        $response = $this->delete(route('admin.housing.prices.price.delete', ['price' => $price]));
        $response->assertOk();

        $this->assertEquals(
            HousingPriceIframe::hideIframeD() . '<br>' . HousingPriceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_all_fields_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.housing.prices.create'), [])
            ->assertInvalid([
                'housing', 'formula', 'type', 'one_price',
                'extra_price',
                'min_nights',
                'weekends', 'weekend_price',
                'kid_bed_price',
                'extra_bed_price',
            ]);
        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [])
            ->assertInvalid([
                'housing', 'formula', 'type', 'one_price',
                'extra_price',
                'min_nights',
                'weekends', 'weekend_price',
                'kid_bed_price',
                'extra_bed_price',
            ]);
    }

    public function test_that_housing_field_should_exists()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => Housing::max('id') + 1,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('housing');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => Housing::max('id') + 1,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('housing');
    }

    public function test_that_formula_field_should_exists()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => HousingFormula::max('id') + 1,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('formula');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => HousingFormula::max('id') + 1,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('formula');
    }

    public function test_that_type_field_should_be_a_season_type()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => 'test',
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('type');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => 'test',
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('type');
    }

    public function test_that_housing_price_cannot_be_stored_or_updated_with_an_existing_season_type_and_housing_and_formula()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('type');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('type');
    }

    public function test_that_one_price_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => 'test',
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('one_price');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => 'test',
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('one_price');
    }

    public function test_that_extra_price_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => 'test',
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('extra_price');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => 'test',
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('extra_price');
    }

    public function test_that_min_nights_field_should_be_an_int()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => 'test',
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('min_nights');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => 'test',
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('min_nights');
    }

    public function test_that_weekends_field_should_be_an_array()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => 'Monday',
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekends');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => 'Sunday',
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekends');
    }

    public function test_that_weekends_field_should_exists()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => ['First', 'Second'],
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekends');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => ['Test', '101'],
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekends');
    }

    public function test_that_weekend_price_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => 'test',
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekend_price');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => 'test',
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('weekend_price');
    }

    public function test_that_kid_bed_price_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => 'test',
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('kid_bed_price');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => 'test',
            'extra_bed_price' => $price->extra_bed_price,
        ])->assertInvalid('kid_bed_price');
    }

    public function test_that_extra_bed_price_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $price = HousingPrice::factory()->create();
        $price->delete();

        $this->post(route('admin.housing.prices.create'), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => 'test',
        ])->assertInvalid('extra_bed_price');

        $this->patch(route('admin.housing.prices.price.edit', ['price' => HousingPrice::factory()->create()]), [
            'housing' => $price->housing_id,
            'formula' => $price->housing_formula_id,
            'type' => $price->type_SHML,
            'one_price' => $price->for_one_price,
            'extra_price' => $price->extra_price,
            'min_nights' => $price->min_nights,
            'weekends' => explode(',', $price->weekendsNames()),
            'weekend_price' => $price->weekend_price,
            'kid_bed_price' => $price->kid_bed_price,
            'extra_bed_price' => 'test',
        ])->assertInvalid('extra_bed_price');
    }
}
