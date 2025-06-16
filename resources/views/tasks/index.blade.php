@extends('layout.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-center">
        <div class="w-full">
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gray-800 text-white px-6 py-4">
                    <h2 class="text-xl font-semibold">Tasks</h2>
                </div>

                <div class="p-6">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-6">
                  <a href="{{ route('tasks.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Create New Task
                        </a>
                    </div>

                    <h4 class="text-lg font-semibold mb-4">Tasks Assigned by Me</h4>
                    @if($assignedTasks->isEmpty())
                        <p class="text-gray-600">No tasks assigned by you.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Title</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Assigned To</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Due Date</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Status</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedTasks as $task)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $task->title }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $task->assignee->name }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                                            <td class="py-2 px-4 border-b border-gray-200 space-x-2">
                                                <a href="{{ route('tasks.show', $task) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">View</a>
                                                <a href="{{ route('tasks.edit', $task) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Edit</a>
                                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <h4 class="text-lg font-semibold mt-8 mb-4">Tasks Assigned to Me</h4>
                    @if($receivedTasks->isEmpty())
                        <p class="text-gray-600">No tasks assigned to you.</p>
                    @else
                        @php
    $statusClasses = [
        'pending' => 'bg-yellow-100 text-yellow-800',
        'in_progress' => 'bg-blue-100 text-blue-800',
        'completed' => 'bg-green-100 text-green-800',
    ];
@endphp
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Title</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Assigned By</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Due Date</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Status</th>
                                        <th class="py-2 px-4 border-b border-gray-200 text-left">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receivedTasks as $task)
<tr class="hover:bg-gray-50 group">
    <td class="py-2 px-4 border-b border-gray-200">{{ $task->title }}</td>
    <td class="py-2 px-4 border-b border-gray-200">{{ $task->assigner->name }}</td>
    <td class="py-2 px-4 border-b border-gray-200">{{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}</td>
    <td class="py-2 px-4 border-b border-gray-200">
        <div class="relative" x-data="{ open: false }">
        <span
            @click="open = !open"
            class="px-2 py-1 rounded text-xs font-semibold cursor-pointer {{ $statusClasses[$task->status] ?? '' }}"
        >
            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
        </span>
        <div
            x-show="open"
            @click.away="open = false"
            class="absolute left-0 mt-1 w-32 bg-white border rounded shadow-lg z-10"
            x-transition
        >
            <form method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="title" value="{{ $task->title }}">
                <input type="hidden" name="description" value="{{ $task->description }}">
                <input type="hidden" name="assigned_to" value="{{ $task->assigned_to }}">
                <input type="hidden" name="due_date" value="{{ $task->due_date }}">
                <button type="submit" name="status" value="pending" class="block w-full text-left px-4 py-2 text-yellow-700 hover:bg-yellow-100 {{ $task->status == 'pending' ? 'font-bold' : '' }}">Pending</button>
                <button type="submit" name="status" value="in_progress" class="block w-full text-left px-4 py-2 text-blue-700 hover:bg-blue-100 {{ $task->status == 'in_progress' ? 'font-bold' : '' }}">In Progress</button>
                <button type="submit" name="status" value="completed" class="block w-full text-left px-4 py-2 text-green-700 hover:bg-green-100 {{ $task->status == 'completed' ? 'font-bold' : '' }}">Completed</button>
            </form>
        </div>
    </div>
    </td>
    <td class="py-2 px-4 border-b border-gray-200">
        <a href="{{ route('tasks.show', $task) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">View</a>
    </td>
</tr>
@endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


