<aside class="w-72 bg-white border-r border-gray-200 flex flex-col shadow-lg z-20 h-screen">
    <!-- Logo/Brand -->
    <div class="p-6 border-b border-gray-100 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">MediCare</h2>
                <p class="text-xs text-gray-500 font-medium">Hospital System</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-6 px-3 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent hover:scrollbar-thumb-gray-400">
        <ul class="space-y-1.5">
            <!-- Dashboard - Management role goes to Management Dashboard -->
            <li>
                @php
                    $dashboardRoute = auth()->user()->hasRole('management') ? route('management.index') : route('dashboard');
                    $isDashboardActive = request()->routeIs('dashboard') || (auth()->user()->hasRole('management') && request()->routeIs('management.*'));
                @endphp
                <a href="{{ $dashboardRoute }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isDashboardActive ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ $isDashboardActive ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ $isDashboardActive ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Dashboard</span>
                </a>
            </li>

            @can('manage-patients')
            <!-- Patients -->
            <li>
                <a href="{{ route('patients.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('patients.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('patients.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Patients</span>
                </a>
            </li>
            @endcan

            @can('manage-appointments')
            <!-- Appointments -->
            <li>
                <a href="{{ route('appointments.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('appointments.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('appointments.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('appointments.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Appointments</span>
                </a>
            </li>
            @endcan

            @can('view-medical-records')
            <!-- Medical Records -->
            <li>
                <a href="{{ route('medical-records.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('medical-records.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('medical-records.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('medical-records.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Medical Records</span>
                </a>
            </li>
            @endcan

            @can('manage-vital-signs')
            <!-- Vital Signs -->
            <li>
                <a href="{{ route('vital-signs.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('vital-signs.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('vital-signs.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('vital-signs.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Vital Signs</span>
                </a>
            </li>
            @endcan

            <!-- Divider -->
            <li class="py-3">
                <div class="flex items-center space-x-3 px-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>
            </li>

            @can('view-laboratory')
            <!-- Laboratory -->
            <li>
                <a href="{{ route('laboratory.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('laboratory.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('laboratory.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('laboratory.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </div>
                    <span class="font-semibold">Laboratory</span>
                </a>
            </li>
            @endcan

            @can('view-radiology')
            <!-- Radiology -->
            <li>
                <a href="{{ route('radiology.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('radiology.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('radiology.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('radiology.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Radiology</span>
                </a>
            </li>
            @endcan

            @can('view-pharmacy')
            <!-- Prescriptions -->
            <li>
                <a href="{{ route('prescriptions.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('prescriptions.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('prescriptions.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('prescriptions.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Prescriptions</span>
                </a>
            </li>
            @endcan

            @can('manage-pharmacy')
            <!-- Medications -->
            <li>
                <a href="{{ route('medications.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('medications.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('medications.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('medications.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Medications</span>
                </a>
            </li>

            <!-- Stock Movements -->
            <li>
                <a href="{{ route('stock-movements.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('stock-movements.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('stock-movements.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('stock-movements.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Stock Movements</span>
                </a>
            </li>
            @endcan

            <!-- Divider -->
            <li class="py-3">
                <div class="flex items-center space-x-3 px-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>
            </li>

            @can('view-billing')
            <!-- Billing -->
            <li>
                <a href="{{ route('billing.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('billing.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('billing.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('billing.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Billing</span>
                </a>
            </li>
            @endcan

            @can('manage-inpatient')
            <!-- Inpatient -->
            <li>
                <a href="{{ route('inpatient.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('inpatient.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('inpatient.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('inpatient.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Inpatient</span>
                </a>
            </li>
            @endcan

            @if(auth()->user()->hasAnyRole(['management', 'admin']))
            <!-- Divider -->
            <li class="py-3">
                <div class="flex items-center space-x-3 px-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>
            </li>

            <!-- Management Reports Section -->
            <li class="px-4 py-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Reports</p>
            </li>

            <!-- Financial Report -->
            <li>
                <a href="{{ route('management.financial') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('management.financial') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('management.financial') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('management.financial') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Financial Report</div>
                        <div class="text-xs {{ request()->routeIs('management.financial') ? 'text-white/80' : 'text-gray-500' }}">Revenue & Outstanding</div>
                    </div>
                </a>
            </li>

            <!-- Operational Performance -->
            <li>
                <a href="{{ route('management.operational') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('management.operational') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('management.operational') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('management.operational') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Operational</div>
                        <div class="text-xs {{ request()->routeIs('management.operational') ? 'text-white/80' : 'text-gray-500' }}">Lab, Rad, Pharmacy, Clinic</div>
                    </div>
                </a>
            </li>

            <!-- Patient Flow -->
            <li>
                <a href="{{ route('management.patient-flow') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('management.patient-flow') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('management.patient-flow') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('management.patient-flow') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Patient Flow</div>
                        <div class="text-xs {{ request()->routeIs('management.patient-flow') ? 'text-white/80' : 'text-gray-500' }}">Visits & Admissions</div>
                    </div>
                </a>
            </li>

            <!-- Staff Performance -->
            <li>
                <a href="{{ route('management.staff-performance') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('management.staff-performance') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('management.staff-performance') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('management.staff-performance') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-semibold">Staff Performance</div>
                        <div class="text-xs {{ request()->routeIs('management.staff-performance') ? 'text-white/80' : 'text-gray-500' }}">Doctors & Technicians</div>
                    </div>
                </a>
            </li>
            @endif

            @can('manage-master-data')
            <!-- Divider -->
            <li class="py-3">
                <div class="flex items-center space-x-3 px-4">
                    <div class="flex-1 h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent"></div>
                </div>
            </li>

            <!-- Master Data Section -->
            <li class="px-4 py-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Master Data</p>
            </li>

            <!-- Doctors -->
            <li>
                <a href="{{ route('doctors.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('doctors.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('doctors.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('doctors.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Doctors</span>
                </a>
            </li>

            <!-- Medications -->
            <li>
                <a href="{{ route('medications.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('medications.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('medications.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('medications.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Medications</span>
                </a>
            </li>

            <!-- Rooms -->
            <li>
                <a href="{{ route('rooms.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('rooms.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('rooms.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('rooms.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Rooms</span>
                </a>
            </li>

            <!-- Departments -->
            <li>
                <a href="{{ route('departments.index') }}" 
                   class="group flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('departments.*') ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <div class="{{ request()->routeIs('departments.*') ? 'bg-white/20' : 'bg-gray-100 group-hover:bg-indigo-50' }} p-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('departments.*') ? 'text-white' : 'text-gray-600 group-hover:text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="font-semibold">Departments</span>
                </a>
            </li>
            @endcan
        </ul>
    </nav>

    <!-- User Info Footer -->
    <div class="p-4 border-t border-gray-100 bg-gray-50 flex-shrink-0">
        <div class="flex items-center space-x-3 px-2">
            <div class="w-11 h-11 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center justify-center shadow-md">
                <span class="text-lg font-bold text-white">{{ strtoupper(substr(Auth::user()->nama, 0, 1)) }}</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->nama }}</p>
                <p class="text-xs text-gray-500 font-medium truncate">{{ ucfirst(Auth::user()->role->nama ?? 'User') }}</p>
            </div>
        </div>
    </div>
</aside>
