<?php

namespace Tests\Feature\Controllers;

use App\Helpers\NotiflixHelper;
use App\Iframes\ResidenceIframe;
use App\Models\Housing;
use App\Models\Residence;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResidenceControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_residence_can_be_stored()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(route('admin.residences.create'), [
            'name' => $residence->name,
            'city' => $residence->city_id,
            'category' => $residence->residence_category_id,
            'description' => $residence->description,
            'website' => $residence->website,
            'email' => $residence->email,
            'contact' => $residence->contact,
            'tax' => $residence->tax,
            'order' => $residence->order_by,
            'active' => $residence->is_active,
        ])->assertOk();

        $this->assertDatabaseHas('residences', $residence->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_that_residence_cannot_be_stored_or_updated_with_an_existing_name_in_the_same_city()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();

        $this->post(route('admin.residences.create'), [
            'name' => $residence->name,
            'city' => $residence->city_id,
            'category' => $residence->residence_category_id,
            'description' => $residence->description,
            'website' => $residence->website,
            'email' => $residence->email,
            'contact' => $residence->contact,
            'tax' => $residence->tax,
            'order' => $residence->order_by,
            'active' => $residence->is_active,
        ])->assertInvalid(['name']);

        $newResidence = Residence::factory()->create();

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => $residence]),
            [
                'name' => $newResidence->name,
                'city' => $newResidence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['name']);
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_residence_is_stored()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $response = $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        );

        $response->assertOk();

        $this->assertEquals(
            ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_residence_can_be_updated()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->patch(route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]), [
            'name' => $residence->name,
            'city' => $residence->city_id,
            'category' => $residence->residence_category_id,
            'description' => $residence->description,
            'website' => $residence->website,
            'email' => $residence->email,
            'contact' => $residence->contact,
            'tax' => $residence->tax,
            'order' => $residence->order_by,
            'active' => $residence->is_active,
        ])->assertOk();

        $this->assertDatabaseHas('residences', $residence->makeHidden(['id', 'created_at', 'updated_at'])->toArray());
    }

    public function test_if_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_residence_is_updated()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $response = $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        );

        $response->assertOk();

        $this->assertEquals(
            ResidenceIframe::iframeCUClose() . '<br>' . ResidenceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_residence_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();

        $this->delete(route('admin.residences.residence.delete', ['residence' => $residence]))->assertOk();

        $this->assertDatabaseMissing('residences', $residence->toArray());
    }

    public function test_that_residence_cannot_be_destroyed_if_it_has_linked_housings()
    {
        $this->actingAsAdmin();

        $residence = Housing::factory()->create()->residence;

        $this->assertEquals(
            NotiflixHelper::report(
                "You can\'t delete $residence->name residence it has linked housings!",
                'failure',
                ResidenceIframe::$iframeDId,
            ),
            $this->delete(route('admin.residences.residence.delete', ['residence' => $residence]))->assertOk()->content()
        );
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_is_reloaded_after_residence_is_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(route('admin.residences.residence.delete', ['residence' => Residence::factory()->create()]));
        $response->assertOk();

        $this->assertEquals(
            ResidenceIframe::hideIframeD() . '<br>' . ResidenceIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_all_fields_except_active_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.residences.create'), [])
            ->assertInvalid(['name', 'city', 'category', 'description', 'website', 'email', 'contact', 'tax', 'order']);

        $this->patch(route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]), [])
            ->assertInvalid(['name', 'city', 'category', 'description', 'website', 'email', 'contact', 'tax', 'order']);
    }

    public function test_that_name_field_should_be_alpha_one_space_between()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => '123',
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['name']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => '123',
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['name']);
    }

    public function test_that_city_field_should_exists_in_database()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => 5,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['city']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => 10,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['city']);
    }

    public function test_that_category_field_should_exists_in_database()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => 5,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['category']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => 5,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['category']);
    }

    public function test_that_website_field_should_be_a_url()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => 'test',
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['website']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => 'test',
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['website']);
    }

    public function test_that_email_field_should_be_a_valid_email()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => 'test',
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['email']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => 'test',
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['email']);
    }

    public function test_that_contact_field_should_be_alpha_one_space_between()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => 'test 101',
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['contact']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => 'test 122',
                'tax' => $residence->tax,
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['contact']);
    }

    public function test_that_tax_field_should_be_numeric()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => 'test',
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['tax']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => 'test',
                'order' => $residence->order_by,
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['tax']);
    }

    public function test_that_order_field_should_be_int()
    {
        $this->actingAsAdmin();

        $residence = Residence::factory()->create();
        $residence->delete();

        $this->post(
            route('admin.residences.create'),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => 'test',
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['order']);

        $this->patch(
            route('admin.residences.residence.edit', ['residence' => Residence::factory()->create()]),
            [
                'name' => $residence->name,
                'city' => $residence->city_id,
                'category' => $residence->residence_category_id,
                'description' => $residence->description,
                'website' => $residence->website,
                'email' => $residence->email,
                'contact' => $residence->contact,
                'tax' => $residence->tax,
                'order' => 'test',
                'active' => $residence->is_active,
            ]
        )->assertInvalid(['order']);
    }
}
