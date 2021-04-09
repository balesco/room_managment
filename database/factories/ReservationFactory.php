<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'begin_at' => $this->faker->time,
            'end_at' => $this->faker->time,
            'description' => $this->faker->text(100),
            'user_id' => \App\Models\User::factory(),
            'room_id' => \App\Models\Room::factory(),
        ];
    }
}
