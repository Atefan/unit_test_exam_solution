use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Photographer; // Ensure you import the model

class PhotographerTest extends TestCase
{
    use RefreshDatabase; // Ensures a clean database for each test

    /** @test */
    public function it_can_list_all_photographers()
    {
        Photographer::factory()->count(3)->create(); // Seed with fake data

        $response = $this->getJson('/api/photographers');

        $response->assertStatus(200)
                 ->assertJsonCount(3); // Check if 3 photographers are returned
    }

    /** @test */
    public function it_can_create_a_photographer()
    {
        $data = [
            'name' => 'Stefan Me',
            'email' => 'Me@Me.com',
            'bio' => 'A professional photographer'
        ];

        $response = $this->postJson('/api/photographers', $data);

        $response->assertStatus(201) // Expect success response
                 ->assertJson([
                     'name' => 'Stefan Stefan',
                     'email' => 'Stefan@example.com',
                 ]);

        $this->assertDatabaseHas('photographers', ['email' => 'Stefan@example.com']);
    }

    /** @test */
    public function it_can_show_a_single_photographer()
    {
        $photographer = Photographer::factory()->create();

        $response = $this->getJson("/api/photographers/{$photographer->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $photographer->id,
                     'name' => $photographer->name,
                 ]);
    }

    /** @test */
    public function it_can_update_a_photographer()
    {
        $photographer = Photographer::factory()->create();

        $updatedData = ['name' => 'Updated Name'];

        $response = $this->putJson("/api/photographers/{$photographer->id}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['name' => 'Updated Name']);

        $this->assertDatabaseHas('photographers', ['name' => 'Updated Name']);
    }

    /** @test */
    public function it_can_delete_a_photographer()
    {
        $photographer = Photographer::factory()->create();

        $response = $this->deleteJson("/api/photographers/{$photographer->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('photographers', ['id' => $photographer->id]);
    }
}
