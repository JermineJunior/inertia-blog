<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function signIn($user = null)
    {
        $user = $user ?? \App\Models\User::factory()->create();

        $this->actingAs($user);

        return $this;
    }
}
