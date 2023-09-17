<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Employee;
use App\project; // This use directive is unnecessary



class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'cpf' => 'required|unique:employees',
            'email' => 'required|email|unique:employees',
            'salary' => 'required|numeric',
        ]);

        // Obtenha project_id dos dados da solicitação ou defina como null se não estiver presente
        $projectId = $request->input('project_id', null);

        // Verifique se project_id é diferente de null e se o projeto existe
        if ($projectId !== null) {
            $project = Project::find($projectId);

            if ($project) {
                // Crie o funcionário e associe-o ao projeto
                $employee = Employee::create($data);
                $employee->projects()->attach($project);
            } else {
                return response()->json(['message' => 'Projeto não encontrado'], 404);
            }
        } else {
            // Crie apenas o funcionário sem associá-lo a nenhum projeto
            $employee = Employee::create($data);
        }

        return response()->json($employee, 201);
    }







    public function show(Employee $employee)
    {
        return response()->json($employee);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:employees',
            'name' => 'required',
            'cpf' => 'required|unique:employees,cpf,' . $request->input('id'),
            'email' => 'required|email|unique:employees,email,' . $request->input('id'),
            'salary' => 'required|numeric',
        ]);

        // Encontre o funcionário com base no ID fornecido no corpo da solicitação
        $employee = Employee::find($data['id']);

        if (!$employee) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        // Atualize os dados do funcionário
        $employee->update([
            'name' => $data['name'],
            'cpf' => $data['cpf'],
            'email' => $data['email'],
            'salary' => $data['salary'],
        ]);

        return response()->json($employee);
    }





    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Funcionário não encontrado'], 404);
        }

        $employee->delete();

        return response()->json(null, 204);
    }



    public function getEmployeesByProject($projectId)
    {
        $employees = Employee::whereExists(function ($query) use ($projectId) {
            $query->select(DB::raw(1))
                ->from('employee_project')
                ->whereRaw('employee_project.employee_id = employees.id')
                ->where('employee_project.project_id', $projectId);
        })->get();


        return response()->json($employees);
    }
}