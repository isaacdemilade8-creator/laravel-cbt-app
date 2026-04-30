<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Workspace') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:col-span-2">
                    <div class="p-8">
                        <p class="text-sm font-semibold uppercase tracking-wide text-blue-700">
                            {{ ucfirst(auth()->user()->role ?? 'student') }}
                        </p>
                        <h3 class="mt-2 text-2xl font-bold text-gray-900">
                            Welcome back, {{ auth()->user()->name }}
                        </h3>
                        <p class="mt-3 max-w-2xl text-gray-600">
                            Use your role workspace to continue exams, manage assessments, or monitor platform activity.
                        </p>

                        <div class="mt-6 flex flex-wrap gap-3">
                            @if (auth()->user()->role === 'admin')
                                <a class="inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white hover:bg-blue-800" href="{{ route('admin.dashboard') }}">
                                    Open Admin Dashboard
                                </a>
                            @elseif (auth()->user()->role === 'teacher')
                                <a class="inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white hover:bg-blue-800" href="{{ route('teacher.exams.index') }}">
                                    Manage Exams
                                </a>
                                <a class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50" href="{{ route('teacher.exams.create') }}">
                                    Create Exam
                                </a>
                            @else
                                <a class="inline-flex items-center rounded-lg bg-blue-700 px-4 py-2 font-semibold text-white hover:bg-blue-800" href="{{ route('student.dashboard') }}">
                                    Open Student Dashboard
                                </a>
                                <a class="inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50" href="{{ route('leaderboard') }}">
                                    View Leaderboard
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-8">
                        <h3 class="text-lg font-bold text-gray-900">Account</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div>
                                <dt class="font-semibold text-gray-500">Email</dt>
                                <dd class="mt-1 text-gray-900">{{ auth()->user()->email }}</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-500">Role</dt>
                                <dd class="mt-1 text-gray-900">{{ ucfirst(auth()->user()->role ?? 'student') }}</dd>
                            </div>
                        </dl>
                        <a class="mt-6 inline-flex items-center rounded-lg border border-gray-300 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50" href="{{ route('profile.edit') }}">
                            Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
