<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'client_id'=>rand(10000 , 999999),
            'portfolio_name'=>$this->faker->name,
            'created_at' => now(),
            'client_no' => 'CL'.rand(1000,9999), // CL000123
        ];
    }
}
