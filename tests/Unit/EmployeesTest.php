<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Employee;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;

class EmployeeTest extends TestCase
{
    use WithFaker, DatabaseTransactions;

    public function createEmployee($name = NULL){
        
        if ($name == NULL) $name = Str::random(6);

        $employee = Employee::factory()->create([
            'first_name' => 'TestFirstName_'.$name,
            'last_name' => 'TestLastName_'.$name,
        ]);
        return $employee->id;
    }

    public function deleteEmployee($id){
        $employee = Employee::find($id);
        $employee->delete();
    }

    /** @test */
    public function employee_can_be_created()
    {
        $name = Str::random(6);
        $employee_id = $this->createEmployee($name);

        $this->assertDatabaseHas('employees', [
            'first_name' => 'TestFirstName_'.$name,
            'last_name' => 'TestLastName_'.$name,
        ]);
    }

    /** @test */
    public function employee_can_be_deleted()
    {
        $name = Str::random(6);
        $employee_id = $this->createEmployee($name);
        $this->deleteEmployee($employee_id);

        $this->assertDatabaseMissing('employees', [
            'first_name' => 'TestFirstName_'.$name,
            'last_name' => 'TestLastName_'.$name,
        ]);
    }
}
