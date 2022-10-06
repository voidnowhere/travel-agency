<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\HousingCategoryIframe;
use App\Models\Housing;
use App\Models\HousingCategory;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HousingCategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_that_housing_category_can_be_stored()
    {
        $this->actingAsAdmin();

        $data = [
            'name' => 'Riad',
            'order' => 1,
            'active' => true,
        ];

        $this->post(route('admin.housing.categories.create'), $data)->assertOk();

        $this->assertDatabaseHas('housing_categories', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_category_is_stored()
    {
        $this->actingAsAdmin();

        $response = $this->post(route('admin.housing.categories.create'), ['name' => 'Riad', 'order' => 1]);
        $response->assertOk();

        $this->assertEquals(
            HousingCategoryIframe::iframeCUClose() . '<br>' . HousingCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_housing_category_can_be_updated()
    {
        $this->actingAsAdmin();

        $category = HousingCategory::factory()->inActive()->create();

        $data = [
            'name' => 'Riad',
            'order' => 1,
            'active' => true,
        ];

        $this->patch(route('admin.housing.categories.category.edit', ['category' => $category]), $data)->assertOk();

        $this->assertDatabaseHas('housing_categories', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_housing_category_is_updated()
    {
        $this->actingAsAdmin();

        $category = HousingCategory::factory()->create();

        $response = $this->patch(
            route('admin.housing.categories.category.edit', ['category' => $category]),
            ['name' => 'Riad', 'order' => 1]
        );
        $response->assertOk();

        $this->assertEquals(
            HousingCategoryIframe::iframeCUClose() . '<br>' . HousingCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_housing_category_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $category = HousingCategory::factory()->create();

        $this->delete(route('admin.housing.categories.category.delete', ['category' => $category]))->assertOk();

        $this->assertDatabaseMissing('housing_categories', $category->toArray());
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_reloaded_after_housing_category_id_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(
            route('admin.housing.categories.category.delete',
                ['category' => HousingCategory::factory()->create()])
        );
        $response->assertOk();

        $this->assertEquals(
            HousingCategoryIframe::hideIframeD() . '<br>' . HousingCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_housing_category_cannot_be_destroyed_if_it_has_linked_housings()
    {
        $this->actingAsAdmin();

        $category = Housing::factory()->create()->category;

        $response = $this->delete(route('admin.housing.categories.category.delete', ['category' => $category]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $category->name category it has linked housings!",
                'failure',
                HousingCategoryIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_that_name_and_order_fields_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.housing.categories.create'), [])->assertInvalid(['name', 'order']);
        $this->patch(
            route('admin.housing.categories.category.edit', ['category' => HousingCategory::factory()->create()]),
            []
        )->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha_one_space_between()
    {
        $this->actingAsAdmin();

        $data = ['name' => 1, 'order' => 1];

        $this->post(route('admin.housing.categories.create'), $data)->assertInvalid(['name']);
        $this->patch(
            route('admin.housing.categories.category.edit', ['category' => HousingCategory::factory()->create()]),
            $data
        )->assertInvalid(['name']);
    }

    public function test_that_housing_category_cannot_be_stored_or_updated_with_an_existing_name()
    {
        $this->actingAsAdmin();

        $category = HousingCategory::factory()->create();
        $data = ['name' => $category->name, 'order' => $category->order_by];

        $this->post(route('admin.housing.categories.create'), $data)->assertInvalid(['name']);
        $this->patch(
            route('admin.housing.categories.category.edit', ['category' => HousingCategory::factory()->create()]),
            $data
        )->assertInvalid(['name']);
    }

    public function test_that_order_should_be_an_int()
    {
        $this->actingAsAdmin();

        $data = ['name' => 'test', 'order' => 'test'];

        $this->post(route('admin.housing.categories.create'), $data)->assertInvalid(['order']);
        $this->patch(
            route('admin.housing.categories.category.edit', ['category' => HousingCategory::factory()->create()]),
            $data
        )->assertInvalid(['order']);
    }
}
