@extends('layouts.app')

@section('title', 'The list of tasks')

@section('content')
    <nav class="mb-4">
        <a class="link" href="{{ route('tasks.create') }}">Add task!</a>
    </nav>

    @if (count($tasks))
        @foreach ($tasks as $task)
            <div>
                <a href="{{ route('tasks.show', ['id' => $task->id]) }}" @class(['line-through' => $task->completed])>{{ $task->title }}</a>
            </div>
        @endforeach
    @else
        <div>There are no tasks</div>
    @endif
    @if ($tasks->count())
        <nav class="mt-4">
            {{ $tasks->links() }}
        </nav>
    @endif
@endsection
