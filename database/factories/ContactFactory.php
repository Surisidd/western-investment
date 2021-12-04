<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ContactID' =>10,
            'ContactName' => "Yasmin Evans",
            'FirstName' =>"Yasmin",
            'MiddleName' => "Evans",
            'LastName' =>"Evans",
            'ContactGroupTypeName' => "individual",
            'Email' =>"test@yasminevans.com",
            'Email2' => "test2@western.com",
            'Email3' =>"",
            'BusinessPhone'=>"078598623",
            "BankDetails"=>"Bank A 3456179",
            'NationalID'=>"25489563",
            'Birthdate' => "2001-06-06",
            'Gender' =>"Female",
            'DeliveryName' => "Yasmin Evans",
            'ContactCode' =>"0010",
        ];
    }
}
