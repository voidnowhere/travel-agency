<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\ResidenceCategoryIframe;
use App\Models\Residence;
use App\Models\ResidenceCategory;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResidenceCategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_residence_category_can_be_stored()
    {
        $this->actingAsAdmin();

        $data = [
            'name' => 'Riad',
            'order' => 1,
            'active' => true,
        ];

        $this->post(route('admin.residence.categories.create'), $data)->assertOk();

        $this->assertDatabaseHas('residence_categories', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_that_residence_category_cannot_be_stored_or_updated_with_an_existing_name()
    {
        $this->actingAsAdmin();

        $category = ResidenceCategory::factory()->create();

        $this->post(route('admin.residence.categories.create'), ['name' => $category->name, 'order' => 1])
            ->assertInvalid(['name']);

        $this->patch(
            route('admin.residence.categories.category.edit', ['category' => $category]),
            ['name' => ResidenceCategory::factory()->create()->name, 'order' => 1]
        )->assertInvalid(['name']);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_residence_category_is_stored()
    {
        $this->actingAsAdmin();

        $response = $this->post(
            route('admin.residence.categories.create'),
            ['name' => 'Riad', 'order' => 1, 'active' => true]
        );
        $response->assertOk();

        $this->assertEquals(
            ResidenceCategoryIframe::iframeCUClose() . '<br>' . ResidenceCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_residence_category_can_be_updated()
    {
        $this->actingAsAdmin();

        $category = ResidenceCategory::factory()->inActive()->create();

        $data = [
            'name' => 'Riad',
            'order' => 1,
            'active' => true,
        ];

        $this->patch(route('admin.residence.categories.category.edit', ['category' => $category]), $data)
            ->assertOk();

        $this->assertDatabaseHas('residence_categories', [
            'name' => $data['name'],
            'order_by' => $data['order'],
            'is_active' => $data['active'],
        ]);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_residence_category_is_updated()
    {
        $this->actingAsAdmin();

        $response = $this->patch(
            route('admin.residence.categories.category.edit', ['category' => ResidenceCategory::factory()->create()]),
            ['name' => 'Riad', 'order' => 1, 'active' => true]
        );
        $response->assertOk();

        $this->assertEquals(
            ResidenceCategoryIframe::iframeCUClose() . '<br>' . ResidenceCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_residence_category_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $category = ResidenceCategory::factory()->create();

        $this->delete(route('admin.residence.categories.category.delete', ['category' => $category]))->assertOk();

        $this->assertDatabaseMissing('residence_categories', $category->toArray());
    }

    public function test_that_residence_category_cannot_be_destroyed_if_it_has_linked_residences()
    {
        $this->actingAsAdmin();

        $category = Residence::factory()->create()->category;

        $response = $this->delete(route('admin.residence.categories.category.delete', ['category' => $category]));
        $response->assertOk();

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $category->name category it has linked residences!",
                'failure',
                ResidenceCategoryIframe::$iframeDId,
            ),
            $response->content()
        );
    }

    public function test_if_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_residence_category_is_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(
            route('admin.residence.categories.category.delete', ['category' => ResidenceCategory::factory()->create()])
        );
        $response->assertOk();

        $this->assertEquals(
            ResidenceCategoryIframe::hideIframeD() . '<br>' . ResidenceCategoryIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_name_and_order_fields_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.residence.categories.create'), [])->assertInvalid(['name', 'order']);
        $this->patch(
            route(
                'admin.residence.categories.category.edit',
                ['category' => ResidenceCategory::factory()->create()]
            ), []
        )->assertInvalid(['name', 'order']);
    }

    public function test_that_name_field_should_be_an_alpha()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.residence.categories.create'), [
            'name' => 2,
            'order' => 1,
        ])->assertInvalid(['name']);

        $this->patch(
            route(
                'admin.residence.categories.category.edit',
                ['category' => ResidenceCategory::factory()->create()]
            ),
            [
                'name' => 2,
                'order' => 1,
            ]
        )->assertInvalid(['name']);
    }

    public function test_that_order_field_should_be_an_int()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.residence.categories.create'), [
            'name' => 'Morocco',
            'order' => 'foo',
        ])->assertInvalid(['order']);

        $this->patch(
            route(
                'admin.residence.categories.category.edit',
                ['category' => ResidenceCategory::factory()->create()]
            ),
            [
                'name' => 'Morocco',
                'order' => 'foo',
            ]
        )->assertInvalid(['order']);
    }
}
