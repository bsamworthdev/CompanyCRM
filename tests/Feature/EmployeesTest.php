<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Employee;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeesTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function employee_can_be_created()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
        $user = User::factory()->create();

        //**************  Code to be tested - Start **************
        $response = $this->actingAs($user)
            ->post('/employees/create', $data);
        //**************  Code to be tested - End  **************

        $this->assertDatabaseHas('employees', $data);
    }

    /** @test */
    public function employee_can_be_deleted()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
        $user = User::factory()->create();

        //Create Employee
        $response = $this->actingAs($user)
            ->post('/employees/create', $data);

        //**************  Code to be tested - Start **************
        //Delete Employee
        $employee_id = Employee::orderBy('id', 'desc')->first()->id;
        $response = $this->actingAs($user)
            ->post('/employees/delete/'.$employee_id);
        //**************  Code to be tested - End **************

        $this->assertDatabaseMissing('employees', $data);
    }

    /** @test */
    public function employee_can_be_updated()
    {
        $data1 = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
        $data2 = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ];
        $user = User::factory()->create();

        //Create Employee
        $response = $this->actingAs($user)
            ->post('/employees/create', $data1);

        //**************  Code to be tested - Start **************
        //Update Employee
        $employee_id = Employee::orderBy('id', 'desc')->first()->id;
        $response = $this->actingAs($user)
            ->post('/employees/update/'.$employee_id, $data2);
        //**************  Code to be tested - End **************

        $this->assertDatabaseMissing('employees', $data1);
        $this->assertDatabaseHas('employees', $data2);
    }
}
