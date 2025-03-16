<nav class="navbar navbar-expand-lg navbar-dark bg-dark p-3 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('teacher.index') }}">📚 نظام إدارة المعلمين</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teacher.index') ? 'active' : '' }}" href="{{ route('teacher.index') }}">
                        👨‍🏫 المعلمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('subtitute.index') ? 'active' : '' }}" href="{{route('substitute.index')}}">
                        📅 جدول الغياب
                    </a>
                </li>
            </ul>

            <!-- زر الرجوع للخلف -->
            <button class="btn btn-outline-light ms-3" onclick="history.back()">
                ⬅ رجوع
            </button>
        </div>
    </div>
</nav>