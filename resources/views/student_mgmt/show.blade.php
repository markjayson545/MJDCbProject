@extends('layouts.app')

@section('title', 'Greetings')

@section('page-title', 'Student View'));
@section('page-subtitle', 'Detailed view of a student')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">{{ $student['fname'] }} {{ $student['mname'] }} {{ $student['lname'] }}</h2>
        <p><strong>Contact Number:</strong> {{ $student['contactno'] }}</p>
        <p><strong>Email Address:</strong> {{ $student['email'] }}</p>
        <p><strong>Description:</strong> {{ $student['description'] }}</p>
        <p><strong>Created At:</strong> {{ $student['created_at'] }}</p>
        <p><strong>Updated At:</strong> {{ $student['updated_at'] }}</p>

        <div class="mt-4">
            <form action="{{ route('studentMgmt.destroy', $student['id']) }}" method="POST" class="inline-block ml-2">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Delete Student
                </button>
            </form>
        </div>

@endsection
