<?php

namespace Tests\Unit;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EntryTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $entry;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->user->addEntry(factory(Entry::class)->make());

        $this->entry = $this->user->entries->first();
    }

    /** @test */
    public function an_entry_can_be_marked_complete()
    {
        $this->entry->markCompleted();

        $this->assertTrue($this->entry->isCompleted());
    }

    /** @test */
    public function an_entry_can_be_marked_incomplete() {
        $this->entry->markCompleted();

        $this->assertTrue($this->entry->isCompleted());

        $this->entry->markIncomplete();

        $this->assertFalse($this->entry->isCompleted());
    }

    /** @test */
    public function an_entry_completion_can_be_toggled() {
        $this->entry->markIncomplete();
        $this->entry->toggleCompletion();

        $this->assertTrue($this->entry->isCompleted());

        $this->entry->toggleCompletion();

        $this->assertFalse($this->entry->isCompleted());
    }
}
