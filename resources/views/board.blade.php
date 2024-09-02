@extends('layouts.app')
@section('title', 'board_name')
@section('content')
    <main class="board-main-content bg4">
        <div class="board-info bg-primary-subtle">
            <span contenteditable="true" class="board-name">Board name</span>
            <button class="btn btn-danger">Delete</button>
        </div>
        <section class="board-content">
            <div class="list-card card bg-body-tertiary"> 
                <ol class="list-group">
                    <li>
                        <div contenteditable="true" class="card-header list-name" >
                            Featured
                        </div>
                    </li>
                    <li class="list-group-item task">task</li>
                    <li class="list-group-item new-task-card">
                        Add a task
                        <div class="add-card" id='new_task'>
                            <input class="form-control" type="text" name="task_name" placeholder="Enter list name...">
                            <button id="add_task_btn" class="btn btn-primary mt-3">Add task</button>
                            <i class="fa-solid fa-xmark close"></i>
                        </div>
                    </li>
                </ol>
            </div>
            <div class="new-list-card card"> 
                Add another list
                <div class="add-card" id="new_list">
                    <input class="form-control" type="text" name="list_name" placeholder="Enter list name...">
                    <button id="add_list_btn" class="btn btn-primary mt-3">Add list</button>
                    <i class="fa-solid fa-xmark close"></i>
                </div>
            </div>
        </section>
  </main>
@endsection