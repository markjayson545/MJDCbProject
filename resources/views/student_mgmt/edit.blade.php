@extends('layouts.app')

@section('title', 'Greetings')

@section('page-title', 'Edit Student'));
@section('page-subtitle', 'Editing of students')

@section('content')

    <div class="bg-white p-6 rounded-lg shadow-md">
        @if(isset($success))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ $success }}</span>
            </div>
        @endif

        @csrf
        <form action="{{ route('studentMgmt.update', $student['id']) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                <input type="text" name="fname" id="fname" value="{{ $student['fname'] }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="mname" class="block text-sm font-medium text-gray-700">Middle Name</label>
                <input type="text" name="mname" id="mname" value="{{ $student['mname'] }}" class="mt-1 block
                    w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div >
                <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                <input type="text" name="lname" id="lname" value="{{ $student['lname'] }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="contactno" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contactno" id="contactno" value="{{ $student['contactno'] }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" value="{{ $student['email'] }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            </div>

            <div>
                <label for="description" required class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ $student['description'] }}</textarea>
            </div>

            <div>
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Student
                </button>
            </div>
        </form>




@endsection
