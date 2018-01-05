<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Liste des tâches de la plus récente à la plus anciene
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Task::latest()->orderBy('created_at', 'desc')->get();
    }

    /**
     * Valide la tâche et l'enregistre dans la BD
     * @return mixed
     */
    public function store()
    {
        $this->validate(request(), [
            'body' => 'required|max:500'
        ]);

        return Task::create(request(['body']));
    }

    /**
     * Retour les infos d'une tâche
     * @param Task $task
     * @return mixed
     */
    public function show(Task $task)
    {
        return Task::findOrFail($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Task $task)
    {
        $this->validate(request(), [
            'body' => 'required|max:500'
        ]);
        $task->body = request('body');
        $task->save();
        return $task;
    }

    /**
     * @param Task $task
     * @return int
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return 204;
    }
}
