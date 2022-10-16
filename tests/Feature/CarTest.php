<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_cars_index_available()
    {
        $response = $this->get(route('cars.index'));

        $response->assertStatus(200);
    }

    public function test_create_new_car_record_with_user()
    {
        $user = $this->createUser();
        $response = $this->postJson(route('cars.store'), ['name' => 'BMW', 'user_id' => $user->id]);

        $response
            ->assertStatus(200)
            ->assertJson(['name' => 'BMW', 'user_id' => $user->id]);
    }

    public function test_update_existing_car_user()
    {
        $userOne = $this->createUser();
        $responseStore = $this->postJson(route('cars.store'), ['name' => 'BMW', 'user_id' => $userOne->id]);

        $userTwo = $this->createUser();
        $responseUpdate = $this->putJson(route('cars.update', $responseStore->getOriginalContent()->id),
            ['car_id' => $responseStore->getOriginalContent()->id, 'user_id' => $userTwo->id]);

        $responseUpdate->assertStatus(200)
            ->assertJsonFragment(['id' => $responseStore->getOriginalContent()->id, 'user_id' => $userTwo->id]);
    }

    public function test_show_single_car_by_id()
    {
        $user = $this->createUser();
        $responseStore = $this->postJson(route('cars.store'), ['name' => 'BMW', 'user_id' => $user->id]);

        $responseGet = $this->get(route('cars.show', $responseStore->getOriginalContent()->id));

        $responseGet->assertStatus(200);
    }

    public function test_only_one_car_record_created()
    {
        $user = $this->createUser();
        $responseStore = $this->postJson(route('cars.store'), ['name' => 'BMW', 'user_id' => $user->id]);
        $this->assertDatabaseCount('cars', 1);
    }

    public function test_create_car_without_user_id()
    {
        $responseStore = $this->postJson(route('cars.store'), ['name' => 'BMW']);
        $responseStore->assertStatus(422)
            ->assertJsonStructure(['errors' => ['user_id']]);
    }

    public function test_create_car_without_car_name()
    {
        $user = $this->createUser();
        $this->postJson(route('cars.store'), ['user_id' => $user->id])
            ->assertStatus(422)
            ->assertJsonStructure(['errors' => ['name']]);
    }

    public function test_delete_a_car_from_database()
    {
        $user = $this->createUser();
        $responseStore = $this->postJson(route('cars.store'), ['name' => 'BMW', 'user_id' => $user->id]);
        $carId = $responseStore->getOriginalContent()->id;
        $this->deleteJson(route('cars.destroy', $carId))->assertSuccessful();

        $this->assertDatabaseMissing('cars', ['name' => 'BMW']);
    }
}
