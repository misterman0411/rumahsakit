<nav class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-600">
                        Hospital MS
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Dashboard
                    </a>

                    @can('manage-patients')
                    <a href="{{ route('patients.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('patients.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Patients
                    </a>
                    @endcan

                    @can('manage-appointments')
                    <a href="{{ route('appointments.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('appointments.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Appointments
                    </a>
                    @endcan

                    @can('view-laboratory')
                    <a href="{{ route('laboratory.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('laboratory.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Laboratory
                    </a>
                    @endcan

                    @can('view-radiology')
                    <a href="{{ route('radiology.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('radiology.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Radiology
                    </a>
                    @endcan

                    @can('view-pharmacy')
                    <a href="{{ route('prescriptions.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('prescriptions.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Pharmacy
                    </a>
                    @endcan

                    @can('view-billing')
                    <a href="{{ route('billing.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('billing.*') ? 'border-blue-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm font-medium">
                        Billing
                    </a>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <span class="text-sm text-gray-700">{{ Auth::user()->nama }}</span>
                    <a href="{{ route('confirm-logout-other-devices') }}" class="ml-3 text-sm text-red-600 hover:text-red-800">
                        Logout Other Devices
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="ml-3 text-sm text-gray-500 hover:text-gray-700">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
