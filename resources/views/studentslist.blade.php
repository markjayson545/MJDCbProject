@foreach($students as $student)

    <div class="p-4 bg-gray-800 rounded-lg shadow-md">

        <h2 class="text-xl font-bold text-green-400 mb-2">{{ $student->lname }}</h2>
        <p class="text-gray-300">Email: {{ $student->email }}</p>

    </div>
@endforeach
