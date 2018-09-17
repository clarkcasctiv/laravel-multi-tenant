<?php

namespace Tests;

Use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TenantAwareTestCase extends TestCase
{
    use RefreshDatabase;

    protected function refreshDatabase()
    {
        parent::refreshApplication();
        $this->artisan('tenancy:install');
    }

    protected function assertSystemDatabaseHas($table, array $data)
    {
        $this->assertDatabaseHas($table, $data, env('DB_CONNECTION'));
    }

    protected function assertSystemDatabaseMissing($table, array $data)
    {
         $this->assertDatabaseHas($table, $data, env('DB_CONNECTION'));
    }
}
