@extends('layouts.app')
@section('title', 'board_name')
@section('content')
    <main class="board-main-content bg1">
        <div class="board-info bg-primary-subtle">
            <span contenteditable="true" class="board-name">Board name</span>
            <button class="btn btn-danger">Delete</button>
        </div>
        <section class="board-content">
            <div class="list-card card">
                <div class="card-header">
                    Featured
                </div>
                <ol class="list-group">
                    <li class="list-group-item">task</li>
                    <li class="list-group-item">Add task</li>
                </ol>
            </div>
            <div class="new-list-card card"> 
                Add another list
                <div class="add-list">
                    <input class="form-control" type="text" placeholder="Enter list name...">
                    <button type="submit" class="btn btn-primary mt-3">Add list</button>
                    <i class="fa-solid fa-xmark close"></i>
                </div>
            </div>
        </section>
  </main>
@endsection