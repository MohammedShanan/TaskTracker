@extends('layouts.app')
@section('title')
{{$board->name}}
@endsection
@section('js')
@vite(['resources/js/board.js'])
@endsection
@section('content')
        <div id="popup" class="popup">
            <div class="popup-content">
        <h2>Delete Board?</h2>
        <p>All lists, cards and actions will be deleted, and you won’t be able to re-open the board. There is no undo.</p>
        <form method="POST" {{route('boards.destroy', $board->id)}}">
            @csrf
            @method('DELETE')
        <button type="submit" class="btn btn-danger">Yes</button>
        <button id="closePopup" class="btn btn-secondary">No</button>
        </form>
            </div>
        </div>
<main class="board-main-content bg4">
    <div class="board-info bg-primary-subtle" >
        <span contenteditable="true" class="board-name" data-name="{{$board->name}}" data-type="board" onblur="changeName(this)" id="board-{{$board->id}}">{{$board->name}}</span>
            <button id="openPopup" class="btn btn-danger">Permanently delete board</button>
    </div>
        <section class="board-content">
            @foreach ($board->lists as $list)
            <div class="list-card card bg-body-tertiary" id="list-{{$list->id}}" >
                <div contenteditable="true" id="list-{{$list->id}}" class="card-header list-name" data-list-name="{{$list->name}}" data-type="list" onblur="changeName(this)">
                            {{$list->name}}
                </div> 
                <ol class="list-group border-0" >
                    @foreach($list->tasks as $task)
                    <li class="list-group-item task" id="task-{{$task->id}}">{{$task->name}}<ul><li></li></li>
                    @endforeach
                    <li class="hide list-group-item" id='new_task'>
                            <div class="add-card"> 
                                <input class="form-control" type="text" name="task_name" placeholder="Enter list name...">
                                <button class="btn btn-primary mt-3" data-list-id="{{$list->id}}" onclick="addTask(this)">Add task</button>
                                <i class="fa-solid fa-xmark close"></i>
                            </div>
                    </li>
                </ol>
                <div class="new-task-card show" data-list-id="{{$list->id}}" onclick="newTaskPrompt(this)">Add a task</div>
            </div>
            @endforeach
            <div class="new-list-card card"> 
                Add another list
                <div class="add-card" id="new_list">
                    <input class="form-control" type="text" name="list_name" placeholder="Enter list name...">
                    <button id="add_list_btn" class="btn btn-primary mt-3" data-board-id="{{$board->id}}">Add list</button>
                    <i class="fa-solid fa-xmark close"></i>
                </div>
            </div>
        </section>
  </main>
@endsection