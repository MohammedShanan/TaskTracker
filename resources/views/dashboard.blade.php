@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<main class="dashboard">
    <aside class="sidebar">
        <h4>Recently viewed</h4>
        <ul class="recent">
            <li><a href="#">Board 4</a></li>
            <li><a href="#">Board 7</a></li>
            <li><a href="#">Board 1</a></li>
            <li><a href="#">Board 3</a></li>
        </ul>
    </aside>
    <section class="boards">
        <div class="new-board">Create new Board</div>
        <div class="new-board-card card"></div>
    @foreach($boards as $board)
    <a class="board bg1" href="{{route('boards.show', 3)}}" id="">{{$board}}</a>
    @endforeach
    </section>
</main>
@endsection