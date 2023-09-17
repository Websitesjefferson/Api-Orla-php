<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;


class ProjectController extends Controller
{
    public function index()
    {
        // Carrega todos os projetos com seus funcionários relacionados
        $projects = Project::with('employees')->get();
        return response()->json($projects);
    }
    public function addEmployee(Request $request, Project $project)
    {
        $data = $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        // Verifique se o funcionário já está associado ao projeto
        if (!$project->employees->contains($data['employee_id'])) {
            // Use o método syncWithoutDetaching para adicionar o funcionário ao projeto
            $project->employees()->syncWithoutDetaching($data['employee_id']);
            return response()->json(['message' => 'Funcionário adicionado ao projeto com sucesso'], 201);
        } else {
            return response()->json(['message' => 'O funcionário já está associado a este projeto'], 400);
        }
    }



    public function getEmployeesByProject(Project $project)
    {
        $employees = $project->employees;
        return response()->json($employees);
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'creation_date' => 'required|date',
        ]);

        $project = Project::create($data);
        return response()->json($project, 201);
    }
    public function show(Project $project)
    {
        $projectWithEmployees = $project->load('employees');
        return response()->json($projectWithEmployees);
    }

    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'id' => 'required|exists:projects',
            // Verifique se o ID do projeto existe
            'name' => 'required',
            'creation_date' => 'required|date',
        ]);

        // Use o ID fornecido no corpo para encontrar o projeto
        $projectToUpdate = Project::findOrFail($data['id']);

        // Atualize os dados do projeto
        $projectToUpdate->update([
            'name' => $data['name'],
            'creation_date' => $data['creation_date'],
        ]);

        return response()->json($projectToUpdate);
    }


    public function destroy($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['message' => 'Projeto não encontrado'], 404);
        }

        // Verifique se o projeto possui funcionários associados e trate conforme necessário
        if ($project->employees()->count() > 0) {
            // Trate aqui a situação em que o projeto possui funcionários associados
            return response()->json(['message' => 'Não é possível excluir o projeto com funcionários associados'], 422); // Status 422 Unprocessable Entity
        }

        // Se o projeto não tiver funcionários associados, exclua-o
        $project->delete();

        return response()->json(null, 204); // Status 204 No Content
    }
}