<?php

namespace App\Traits;

use App\Models\User;

trait FeatureTestTrait
{
    public function actingAsAdmin()
    {
        return $this->actingAs(User::factory()->admin()->create());
    }

    public function actingAsClient()
    {
        return $this->actingAs(User::factory()->create());
    }
}
