<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\HousingFormulaIframe;
use App\Models\HousingFormula;
use App\Models\HousingPrice;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HousingFormulaControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_housing_formula_can_be_stored()
    {
        $this->actingAsAdmin();

        $data = [
            'name' => 'Dinner',
            'order' => 1,
            'active' => true,
        ];

        $this->post(route('admin.housing.formulas.create'), $data)->assertOk();

        $this->assertDatabaseHas('housing_formulas', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_formula_is_stored()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.housing.formulas.create'), ['name' => 'Dinner', 'order' => 1]);
        $response->assertOk();

        $this->assertEquals(
            HousingFormulaIframe::iframeCUClose() . '<br>' . HousingFormulaIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_housing_formula_can_be_updated()
    {
        $this->actingAsAdmin();

        $data = [
            'name' => 'Dinner',
            'order' => 5,
            'active' => false,
        ];

        $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]),
            $data
        )->assertOk();

        $this->assertDatabaseHas('housing_formulas', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_formula_is_updated()
    {
        $this->actingAsAdmin();

        $response = $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]),
            ['name' => 'Dinner', 'order' => 5]
        );
        $response->assertOk();

        $this->assertEquals(
            HousingFormulaIframe::iframeCUClose() . '<br>' . HousingFormulaIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_housing_formula_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $formula = HousingFormula::factory()->create();

        $this->delete(route('admin.housing.formulas.formula.delete', ['formula' => $formula]))->assertOk();

        $this->assertDatabaseMissing('housing_formulas', $formula->toArray());
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_is_closed_after_housing_formula_is_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(
            route('admin.housing.formulas.formula.delete', ['formula' => HousingFormula::factory()->create()])
        );
        $response->assertOk();

        $this->assertEquals(
            HousingFormulaIframe::hideIframeD() . '<br>' . HousingFormulaIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_housing_formula_cannot_be_destroyed_if_it_has_linked_prices()
    {
        $this->actingAsAdmin();

        $formula = HousingPrice::factory()->create()->formula;

        $response = $this->delete(route('admin.housing.formulas.formula.delete', ['formula' => $formula]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $formula->name formula it has linked prices!",
                'failure',
                HousingFormulaIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_that_name_and_order_fields_are_required_when_storing_housing_formula()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.housing.formulas.create'), [])->assertInvalid(['name', 'order']);
    }

    public function test_that_name_and_order_fields_are_required_when_updating_housing_formula()
    {
        $this->actingAsAdmin();

        $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]), []
        )->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha_one_space_between_when_storing_housing_formula()
    {
        $this->actingAsAdmin();

        $data = ['name' => 1, 'order' => 1];

        $this->post(route('admin.housing.formulas.create'), $data)->assertInvalid(['name']);
    }

    public function test_that_name_field_should_be_an_alpha_one_space_between_when_updating_housing_formula()
    {
        $this->actingAsAdmin();

        $data = ['name' => 1, 'order' => 1];

        $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]), $data
        )->assertInvalid(['name']);
    }

    public function test_that_housing_formula_cannot_be_stored_with_an_existing_name()
    {
        $this->actingAsAdmin();

        $formula = HousingFormula::factory()->create();
        $data = ['name' => $formula->name, 'order' => 1];

        $this->post(route('admin.housing.formulas.create'), $data)->assertInvalid(['name']);
    }

    public function test_that_housing_formula_cannot_be_updated_with_an_existing_name()
    {
        $this->actingAsAdmin();

        $formula = HousingFormula::factory()->create();
        $data = ['name' => $formula->name, 'order' => 1];

        $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]), $data
        )->assertInvalid(['name']);
    }

    public function test_that_order_field_should_be_is_an_int_when_storing_housing_formula()
    {
        $this->actingAsAdmin();

        $data = ['name' => 'Dinner', 'order' => 'test'];

        $this->post(route('admin.housing.formulas.create'), $data)->assertInvalid(['order']);
    }

    public function test_that_order_field_should_be_is_an_int_when_updating_housing_formula()
    {
        $this->actingAsAdmin();

        $data = ['name' => 'Dinner', 'order' => 'test'];

        $this->patch(
            route('admin.housing.formulas.formula.edit', ['formula' => HousingFormula::factory()->create()]), $data
        )->assertInvalid(['order']);
    }
}
