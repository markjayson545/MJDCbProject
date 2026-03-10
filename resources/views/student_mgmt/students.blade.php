@extends('layouts.app')

@section('title', 'Greetings')

@section('page-title', 'Student Management'));
@section('page-subtitle', 'List of all students in the system')

@section('content')
    <div class="overflow-hidden rounded-lg shadow-md bg-white" style="justify-content: center; justify-items: center">
        <table class="min-w-full divide-y divide-gray-200" style="text-align: center">
            <thead class="bg-gradient-to-r from-rose-500 to-rose-600">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-black uppercase tracking-wider">
                        Number
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-black uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-black uppercase tracking-wider">
                        Age
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-black uppercase tracking-wider">
                        Label
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($students ?? [] as $student)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $student['name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $student['age'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            @if($student['age'] <= 19)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                    Freshman Student
                                </span>
                            @elseif($student['age'] <= 20)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                    Sophomore Student
                                </span>
                            @elseif($student['age'] <= 21)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    Junior Student
                                </span>
                            @elseif($student['age'] <= 22)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-orange-100 text-orange-800">
                                    Senior Student
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800">
                                    Irregular Student
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-sm text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <p class="mt-3 font-medium">No students found.</p>
                            <p class="mt-1 text-xs text-gray-400">Start by adding students to the system.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
