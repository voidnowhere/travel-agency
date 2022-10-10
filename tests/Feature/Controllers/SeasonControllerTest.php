<?php

namespace Tests\Feature\Controllers;

use App\Iframes\SeasonIframe;
use App\Models\Season;
use App\Traits\FeatureTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeasonControllerTest extends TestCase
{
    use RefreshDatabase;
    use FeatureTestTrait;

    public function test_if_season_can_be_stored()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from->toDateString(),
            'to' => $season->date_to->toDateString(),
            'type' => $season->type_SHML,
            'description' => $season->description,
            'active' => $season->is_active
        ])->assertOk();

        $this->assertDatabaseHas('seasons', [
            'description' => $season->description,
            'date_from' => $season->date_from,
            'date_to' => $season->date_to,
            'type_SHML' => $season->type_SHML,
            'is_active' => $season->is_active,
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_season_is_stored()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $response = $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from->toDateString(),
            'to' => $season->date_to->toDateString(),
            'type' => $season->type_SHML,
            'description' => $season->description,
            'active' => $season->is_active
        ]);
        $response->assertOk();

        $this->assertEquals(
            SeasonIframe::iframeCUClose() . '<br>' . SeasonIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_season_can_be_updated()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->patch(route('admin.seasons.season.edit', ['season' => Season::factory()->create()]), [
            'from' => $season->date_from->toDateString(),
            'to' => $season->date_to->toDateString(),
            'type' => $season->type_SHML,
            'description' => $season->description,
            'active' => $season->is_active
        ])->assertOk();

        $this->assertDatabaseHas('seasons', [
            'description' => $season->description,
            'date_from' => $season->date_from,
            'date_to' => $season->date_to,
            'type_SHML' => $season->type_SHML,
            'is_active' => $season->is_active,
        ]);
    }

    public function test_that_create_update_iframe_is_closed_and_parent_iframe_is_reloaded_after_season_is_updated()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $response = $this->patch(route('admin.seasons.season.edit', ['season' => Season::factory()->create()]), [
            'from' => $season->date_from->toDateString(),
            'to' => $season->date_to->toDateString(),
            'type' => $season->type_SHML,
            'description' => $season->description,
            'active' => $season->is_active
        ]);
        $response->assertOk();

        $this->assertEquals(
            SeasonIframe::iframeCUClose() . '<br>' . SeasonIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_if_season_can_be_destroyed()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();

        $this->delete(route('admin.seasons.season.delete', ['season' => $season]))->assertOk();

        $this->assertDatabaseMissing('seasons', [
            'description' => $season->description,
            'date_from' => $season->date_from,
            'date_to' => $season->date_to,
            'type_SHML' => $season->type_SHML,
            'is_active' => $season->is_active,
        ]);
    }

    public function test_that_delete_iframe_is_hidden_and_parent_iframe_is_closed_after_season_is_destroyed()
    {
        $this->actingAsAdmin();

        $response = $this->delete(route('admin.seasons.season.delete', ['season' => Season::factory()->create()]));
        $response->assertOk();

        $this->assertEquals(
            SeasonIframe::hideIframeD() . '<br>' . SeasonIframe::reloadParent(),
            $response->content()
        );
    }

    public function test_that_all_fields_except_active_are_required()
    {
        $this->actingAsAdmin();

        $this->post(route('admin.seasons.create'), [])->assertInvalid(['from', 'to', 'type', 'description']);

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            []
        )->assertInvalid(['from', 'to', 'type', 'description']);
    }

    public function test_that_from_field_should_be_a_date()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->post(route('admin.seasons.create'), [
            'from' => 1,
            'to' => $season->date_to,
            'type' => $season->type_SHML,
            'description' => $season->description,
        ])->assertInvalid('from');

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            [
                'from' => 'test',
                'to' => $season->date_to,
                'type' => $season->type_SHML,
                'description' => $season->description,
            ]
        )->assertInvalid('from');
    }

    public function test_that_to_field_should_be_a_date()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from,
            'to' => 1,
            'type' => $season->type_SHML,
            'description' => $season->description,
        ])->assertInvalid('to');

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            [
                'from' => $season->date_from,
                'to' => 'test',
                'type' => $season->type_SHML,
                'description' => $season->description,
            ]
        )->assertInvalid('to');
    }

    public function test_that_to_field_should_be_after_from_field()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from,
            'to' => $season->date_from->subDay(),
            'type' => $season->type_SHML,
            'description' => $season->description,
        ])->assertInvalid('to');

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            [
                'from' => $season->date_from,
                'to' => $season->date_from,
                'type' => $season->type_SHML,
                'description' => $season->description,
            ]
        )->assertInvalid('to');
    }

    public function test_that_type_field_should_be_a_season_type()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();
        $season->delete();

        $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from,
            'to' => $season->date_to,
            'type' => 'test',
            'description' => $season->description,
        ])->assertInvalid('type');

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            [
                'from' => $season->date_from,
                'to' => $season->date_to,
                'type' => 'test',
                'description' => $season->description,
            ]
        )->assertInvalid('type');
    }

    public function test_that_season_cannot_be_stored_or_updated_withe_an_existing_season_type_and_date_from_and_date_to()
    {
        $this->actingAsAdmin();

        $season = Season::factory()->create();

        $this->post(route('admin.seasons.create'), [
            'from' => $season->date_from,
            'to' => $season->date_to,
            'type' => $season->type_SHML,
            'description' => $season->description,
        ])->assertInvalid('type');

        $this->patch(
            route('admin.seasons.season.edit', ['season' => Season::factory()->create()]),
            [
                'from' => $season->date_from,
                'to' => $season->date_to,
                'type' => $season->type_SHML,
                'description' => $season->description,
            ]
        )->assertInvalid('type');
    }
}
