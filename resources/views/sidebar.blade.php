<div class="sidebar bg-dark text-white" style="width: 250px; min-height: 100vh; position: fixed;">
    <div class="sidebar-header p-4 border-bottom">
        <h3 class="mb-0">
            <i class="fas fa-user-shield me-2"></i>Admin Panel
        </h3>
    </div>
    <div class="list-group list-group-flush mt-3">
        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
            class="list-group-item list-group-item-action text-white bg-dark {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>

        <!-- Students Section -->
        <a href="#studentsSection"
            class="list-group-item list-group-item-action text-white bg-dark d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse">
            <span><i class="fas fa-users me-2"></i> Students</span>
            <i class="fas fa-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('users.*') ? 'show' : '' }}" id="studentsSection">
            <a href="{{ route('users.index') }}"
                class="list-group-item list-group-item-action text-white bg-dark ps-5 {{ request()->routeIs('users.index') ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i> All Students
            </a>
            <a href="{{ route('users.create') }}"
                class="list-group-item list-group-item-action text-white bg-dark ps-5 {{ request()->routeIs('users.create') ? 'active' : '' }}">
                <i class="fas fa-plus-circle me-2"></i> Create Student
            </a>
        </div>

        <!-- Subjects Section -->
        <a href="#subjectsSection"
            class="list-group-item list-group-item-action text-white bg-dark d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse">
            <span><i class="fas fa-book me-2"></i> Subjects</span>
            <i class="fas fa-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('subjects.*') ? 'show' : '' }}" id="subjectsSection">
            <a href="{{ route('subjects.index') }}"
                class="list-group-item list-group-item-action text-white bg-dark ps-5 {{ request()->routeIs('subjects.index') ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i> All Subjects
            </a>
        </div>

        <!-- Payments Section -->
        <a href="#paymentsSection"
            class="list-group-item list-group-item-action text-white bg-dark d-flex justify-content-between align-items-center"
            data-bs-toggle="collapse">
            <span><i class="fas fa-money-bill-wave me-2"></i> Payments</span>
            <i class="fas fa-chevron-down"></i>
        </a>
        <div class="collapse {{ request()->routeIs('payments.*') ? 'show' : '' }}" id="paymentsSection">
            <a href="{{ route('payments.select-subject') }}"
                class="list-group-item list-group-item-action text-white bg-dark ps-5 {{ request()->routeIs('payments.select-subject') ? 'active' : '' }}">
                <i class="fas fa-list me-2"></i> All Payments
            </a>
        </div>

        <a href="{{ route('rates.select-subject') }}"
            class="list-group-item list-group-item-action text-white bg-dark {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-star me-2"></i> Rate Students
        </a>
        <a href="{{ route('users.archive') }}" 
        class="list-group-item list-group-item-action text-white {{ request()->routeIs('users.archive') ? 'bg-primary' : 'bg-dark' }}">
        <i class="fas fa-trash-alt me-2"></i> Trash Users
        <span class="badge bg-danger float-end">{{ App\Models\User::onlyTrashed()->count() }}</span>
     </a>
    </div>
</div>
