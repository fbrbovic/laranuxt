<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * State that sets up Faruk Porfile in the database
     *
     * @return Factory
     */
    public function farukProfile() {
        return $this->state(function (array $attributes) {
            return [
                'id' => 1,
                'name' => 'Faruk Brbovic',
            ];
        });
    }
}
