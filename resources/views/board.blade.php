@extends('layouts.app')
@section('title', 'board_name')
@section('content')
    <main class="board-main-content bg4">
        <div class="board-info bg-primary-subtle">
            <span contenteditable="true" class="board-name" data-board-name="Tekken 7" data-type="board" onblur="changeName(this)">Tekken 7</span>
            <button class="btn btn-danger">Delete</button>
        </div>
        <section class="board-content">
            <div class="list-card card bg-body-tertiary" id="list-1">
                <div contenteditable="true" class="card-header list-name" data-list-name="Featured" data-type="list" onblur="changeName(this)">
                            Featured
                </div> 
                <ol class="list-group border-0" >
                    {{-- <li class="list-group-item task">test</li> --}}
                    <li class="hide list-group-item" id='new_task'>
                            <div class="add-card"> 
                                <input class="form-control" type="text" name="task_name" placeholder="Enter list name...">
                                <button class="btn btn-primary mt-3" data-list-id="list-1" onclick="addTask(this)">Add task</button>
                                <i class="fa-solid fa-xmark close"></i>
                            </div>
                    </li>
                </ol>
                <div class="new-task-card show" data-list-id="list-1" onclick="newTaskPrompt(this)">Add a task</div>
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