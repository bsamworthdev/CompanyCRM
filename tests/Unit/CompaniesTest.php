<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Company;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;

class CompanyTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function createCompany($name = NULL){
        
        if ($name == NULL) $name = Str::random(6);

        $company = Company::factory()->create([
            'name' => 'TestName_'.$name
        ]);
        return $company->id;
    }

    /** @test */
    public function company_can_be_created()
    {
        $name = Str::random(6);
        $company_id = $this->createCompany($name);

        $this->assertDatabaseHas('companies', [
            'name' => 'TestName_'.$name
        ]);
    }
}
