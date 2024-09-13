@extends('layouts.app')
@section('title', 'Dashboard')
@section('js')
    @vite(['resources/js/dashboard.js'])
@endsection
@section('content')
    <main class="dashboard">
        <aside class="sidebar">
            <h4>Recently viewed</h4>
            <ul class="recent">
                @foreach ($recently_viewed as $id => $boardName)
                    <li><a href="{{ route('boards.show', $id) }}">{{ $boardName }}</a></li>
                @endforeach
            </ul>
        </aside>
        <section class="boards">
            <div class="new-board">Create new Board</div>
            <div class="new-board-card card"></div>
            @foreach ($boards as $board)
                <a class="board bg1" href="{{ route('boards.show', $board->id) }}"
                    id="{{ $board->id }}">{{ $board->name }}</a>
            @endforeach
        </section>
    </main>
@endsection
