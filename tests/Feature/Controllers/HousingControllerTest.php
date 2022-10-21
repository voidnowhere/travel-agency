<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\HousingIframe;
use App\Models\Housing;
use App\Models\HousingCategory;
use App\Models\HousingPrice;
use App\Models\Residence;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HousingControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_housing_can_be_stored()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
            'active' => $housing->is_active,
        ])->assertOk();

        $this->assertDatabaseHas('housings', $housing->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_is_stored()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $response = $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
            'active' => $housing->is_active,
        ]);
        $response->assertOk();

        $this->assertEquals(
            HousingIframe::iframeCUClose() . '<br>' . HousingIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_get_housings_as_json()
    {
        $this->actingAsAdmin();

        $residence = Housing::factory()->create()->residence;

        $response = $this->post(route('admin.housings.get'), ['residence_id' => $residence->id]);
        $response->assertOk();

        $this->assertEquals(
            $residence->housings()->orderBy('order_by')->get(['id', 'name']),
            $response->content()
        );
    }

    public function test_get_only_active_housings_as_json()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();

        Housing::factory()->inActive()->create(['residence_id' => $residence->id]);
        Housing::factory()->active()->create(['residence_id' => $residence->id]);

        $response = $this->post(route('housings.get'), ['residence_id' => $residence->id]);
        $response->assertOk();

        $this->assertEquals(
            $residence->housings()->active()->orderBy('order_by')->get(['id', 'name']),
            $response->content()
        );
    }

    public function test_if_housing_can_be_updated()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
            'active' => $housing->is_active,
        ])->assertOk();

        $this->assertDatabaseHas('housings', $housing->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_is_updated()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $response = $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
            'active' => $housing->is_active,
        ]);
        $response->assertOk();

        $this->assertEquals(
            HousingIframe::iframeCUClose() . '<br>' . HousingIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_housing_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();

        $this->delete(route('admin.housings.housing.delete', ['housing' => $housing]))->assertOk();

        $this->assertDatabaseMissing('housings', $housing->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_housing_is_destroyed()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();

        $response = $this->delete(route('admin.housings.housing.delete', ['housing' => $housing]));
        $response->assertOk();

        $this->assertEquals(
            HousingIframe::hideIframeD() . '<br>' . HousingIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_housing_cannot_be_deleted_if_he_has_linked_prices()
    {
        $this->actingAsAdmin();

        $housing = HousingPrice::factory()->create()->housing;

        $response = $this->delete(route('admin.housings.housing.delete', ['housing' => $housing]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $housing->name housing it has linked prices!",
                'failure',
                HousingIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_that_all_fields_except_active_are_required_when_storing_housing()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.housings.create'), [])->assertInvalid([
            'name', 'residence', 'category', 'description', 'max', 'order'
        ]);
    }

    public function test_that_all_fields_except_active_are_required_when_updating_housing()
    {
        $this->actingAsAdmin();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [])
            ->assertInvalid(['name', 'residence', 'category', 'description', 'max', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha_one_space_between_when_storing_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(
            route('admin.housings.create'),
            [
                'name' => 1,
                'residence' => $housing->residence_id,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['name']);
    }

    public function test_that_name_field_should_be_an_alpha_one_space_between_when_updating_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => 1,
                'residence' => $housing->residence_id,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['name']);
    }

    public function test_that_housing_cannot_be_stored_with_an_existing_name_for_the_same_residence_and_housing_category()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
        ])->assertInvalid(['name']);
    }

    public function test_that_housing_cannot_be_updated_with_an_existing_name_for_the_same_residence_and_housing_category()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => $housing->name,
                'residence' => $housing->residence_id,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['name']);
    }

    public function test_that_residence_field_should_exists_when_storing_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => Residence::max('id') + 1,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
        ])->assertInvalid(['residence']);
    }

    public function test_that_residence_field_should_exists_when_updating_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => $housing->name,
                'residence' => Residence::max('id') + 1,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['residence']);
    }

    public function test_that_housing_category_field_should_exists_when_storing_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => HousingCategory::max('id') + 1,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => $housing->order_by,
        ])->assertInvalid(['category']);
    }

    public function test_that_housing_category_field_should_exists_when_updating_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => $housing->name,
                'residence' => $housing->residence_id,
                'category' => HousingCategory::max('id') + 1,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['category']);
    }

    public function test_that_max_field_should_be_an_int_when_storing_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => 'foo',
            'order' => $housing->order_by,
        ])->assertInvalid(['max']);
    }

    public function test_that_max_field_should_be_an_int_when_updating_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => $housing->name,
                'residence' => $housing->residence_id,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => 'foo',
                'order' => $housing->order_by,
            ]
        )->assertInvalid(['max']);
    }

    public function test_that_order_field_should_be_an_int_when_storing_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->post(route('admin.housings.create'), [
            'name' => $housing->name,
            'residence' => $housing->residence_id,
            'category' => $housing->housing_category_id,
            'description' => $housing->description,
            'max' => $housing->for_max,
            'order' => 'foo',
        ])->assertInvalid(['order']);
    }

    public function test_that_order_field_should_be_an_int_when_updating_housing()
    {
        $this->actingAsAdmin();

        $housing = Housing::factory()->create();
        $housing->delete();

        $this->patch(route('admin.housings.housing.edit', ['housing' => Housing::factory()->create()]), [
                'name' => $housing->name,
                'residence' => $housing->residence_id,
                'category' => $housing->housing_category_id,
                'description' => $housing->description,
                'max' => $housing->for_max,
                'order' => 'foo',
            ]
        )->assertInvalid(['order']);
    }
}
