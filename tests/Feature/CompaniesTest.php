<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;

class CompaniesTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    /** @test */
    public function company_can_be_created()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'logo' => $this->faker->url,
            'website' => $this->faker->url,
        ];
        $user = User::factory()->create();

        //**************  Code to be tested - Start **************
        //Create Company
        $response = $this->actingAs($user)
            ->post('/companies/create', $data);
        //**************  Code to be tested - End  **************

        $this->assertDatabaseHas('companies', $data);
    }

    /** @test */
    public function company_can_be_deleted()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'logo' => $this->faker->url,
            'website' => $this->faker->url,
        ];
        $user = User::factory()->create();

        //Create Company
        $response = $this->actingAs($user)
            ->post('/companies/create', $data);

        //**************  Code to be tested - Start **************
        //Delete Company
        $company_id = Company::orderBy('created_at', 'desc')->first()->id;
        $response = $this->actingAs($user)
            ->post('/companies/delete/'.$company_id, ['id' => $company_id]);
        //**************  Code to be tested - End **************

        $this->assertDatabaseMissing('companies', $data);
    }

    /** @test */
    public function company_can_be_updated()
    {
        $data1 = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'logo' => $this->faker->url,
            'website' => $this->faker->url,
        ];
        $data2 = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'logo' => $this->faker->url,
            'website' => $this->faker->url,
        ];
        $user = User::factory()->create();

        //Create company
        $response = $this->actingAs($user)
            ->post('/companies/create', $data1);

        //**************  Code to be tested - Start **************
        //Update company
        $employee_id = Company::orderBy('id', 'desc')->first()->id;
        $response = $this->actingAs($user)
            ->post('/companies/update/'.$employee_id, $data2);
        //**************  Code to be tested - End **************

        $this->assertDatabaseMissing('companies', $data1);
        $this->assertDatabaseHas('companies', $data2);
    }
}
