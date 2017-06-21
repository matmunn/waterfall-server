<?php

namespace Tests\Unit;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /** @test */
    public function a_user_has_entries()
    {
        $this->user->entries()->save(factory(Entry::class)->make());

        $this->assertTrue($this->user->entries()->count() > 0);
    }

    /** @test */
    public function a_user_can_add_an_entry_from_an_array()
    {

        $this->user->addEntry(factory(Entry::class)->raw());

        $this->assertCount(1, $this->user->entries);
    }

    /** @test */
    public function a_user_can_add_an_entry_from_a_model() {
        $this->user->addEntry(factory(Entry::class)->make());

        $this->assertCount(1, $this->user->entries);
    }

    /** @test */
    public function a_user_can_add_multiple_entries() {
        $this->user->addEntries(factory(Entry::class, 5)->raw());

        $this->assertCount(5, $this->user->entries);
    }

    /** @test */
    public function a_user_can_add_multiple_mixed_entries() {
        $this->user->addEntries(array_merge(factory(Entry::class, 3)->raw(), factory(Entry::class, 2)->make()->toArray()));

        $this->assertCount(5, $this->user->entries);
    }
}
