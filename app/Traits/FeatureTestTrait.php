<?php

namespace App\Traits;

use App\Models\User;

trait FeatureTestTrait
{
    public function actingAsAdmin()
    {
        $user = User::factory()->admin()->create();

        return $this->actingAs($user);
    }

    public function actingAsClient()
    {
        $user = User::factory()->create();

        return $this->actingAs($user);
    }
}
