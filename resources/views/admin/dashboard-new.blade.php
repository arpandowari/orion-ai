@extends('layouts.app')

@section('title', 'Admin Dashboard - ORION AI')

@section('styles')
<style>
    .admin-layout {
        display: flex;
        gap: 2rem;
        min-height: calc(100vh - 200px);
    }

    .sidebar {
        width: 250px;
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .sidebar-header {
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--light);
        margin-bottom: 1rem;
    }

    .sidebar-header h2 {
        color: var(--primary);
        font-size: 1.25rem;
        margin-bottom: 0.25rem;
    }

    .sidebar-header p {
        color: #64748b;
        font-size: 0.875rem;
    }

    .sidebar-menu {
        list-style: none;
    }

    .sidebar-menu li {
        margin-bottom: 0.5rem;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        color: var(--dark);
        font-weight: 500;
        transition: all 0.3s;
    }

    .sidebar-menu a:hover {
        background: var(--light);
        color: var(--secondary);
    }

    .sidebar-menu a.active {
        background: var(--secondary);
        color: white;
    }

    .sidebar-menu .icon {
        font-size: 1.25rem;
    }

    .sidebar-section {
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 2px solid var(--light);
    }

    .sidebar-section-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        padding-left: 1rem;
    }

    .main-content {
        flex: 1;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 4px solid var(--secondary);
    }

    .stat-card h3 {
        color: #64748b;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .stat-card .number {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary);
    }

    .tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .tab-btn {
        padding: 0.75rem 1.5rem;
        background: white;
        border: 2px solid var(--secondary);
        color: var(--secondary);
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }

    .tab-btn.active {
        background: var(--secondary);
        color: white;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }

    .action-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .btn-add {
        background: var(--success);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add:hover {
        background: #059669;
    }

    .data-table {
        background: white;
        border-radius: 12px;
        overflow-x: auto;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
    }

    th {
        background: var(--primary);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
    }

    td {
        padding: 1rem;
        border-bottom: 1px solid #e2e8f0;
    }

    tr:hover {
        background: var(--light);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-active {
        background: #d1fae5;
        color: #065f46;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-contacted {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-verified {
        background: #d1fae5;
        color: #065f46;
    }

    .action-btns {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

    .btn-view {
        background: #8b5cf6;
        color: white;
    }

    .btn-view:hover {
        background: #7c3aed;
    }

    .course-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }

    .course-card h3 {
        color: var(--primary);
        margin-bottom: 1rem;
    }

    .video-list {
        margin-top: 1rem;
    }

    .video-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--light);
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .video-info {
        flex: 1;
    }

    .video-title {
        font-weight: 600;
        color: var(--dark);
    }

    .video-meta {
        font-size: 0.875rem;
        color: #64748b;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        z-index: 9999;
        align-items: center;
        justify-content: center;
    }

    .modal.active {
        display: flex;
    }

    .modal-content {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h2 {
        color: var(--primary);
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #64748b;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: var(--dark);
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .search-box {
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        width: 300px;
    }

    @media (max-width: 768px) {
        .admin-layout {
            flex-direction: column;
        }

        .sidebar {
            width: 100%;
            position: relative;
            top: 0;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            width: 100%;
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
                <p>{{ auth()->user()->name }}</p>
            </div>

            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="active">
                        <span class="icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.courses.create') }}">
                        <span class="icon">➕</span>
                        <span>Add Course</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.videos.create') }}">
                        <span class="icon">🎬</span>
                        <span>Add Video</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Quick Stats</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="#" onclick="switchTab('courses'); return false;">
                            <span class="icon">📚</span>
                            <span>{{ $courses->count() }} Courses</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="switchTab('videos'); return false;">
                            <span class="icon">🎥</span>
                            <span>{{ $totalVideos }} Videos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="switchTab('registrations'); return false;">
                            <span class="icon">👥</span>
                            <span>{{ $registrations->count() }} Students</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="switchTab('placements'); return false;">
                            <span class="icon">🎯</span>
                            <span>{{ $placements->count() }} Placements</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-section">
                <div class="sidebar-section-title">Navigation</div>
                <ul class="sidebar-menu">
                    <li>
                        <a href="{{ route('home') }}" target="_blank">
                            <span class="icon">🌐</span>
                            <span>View Website</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('courses.index') }}" target="_blank">
                            <span class="icon">📖</span>
                            <span>View Courses</span>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 0; cursor: pointer;">
                                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 8px; text-decoration: none; color: var(--dark); font-weight: 500;">
                                    <span class="icon">🚪</span>
                                    <span>Logout</span>
                                </a>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <div class="dashboard-header">
                <h1>Admin Dashboard</h1>
                <p>Manage courses, videos, and student registrations</p>
            </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Courses</h3>
            <div class="number">{{ $courses->count() }}</div>
        </div>
        <div class="stat-card">
            <h3>Total Videos</h3>
            <div class="number">{{ $totalVideos }}</div>
        </div>
        <div class="stat-card">
            <h3>Registrations</h3>
            <div class="number">{{ $registrations->count() }}</div>
        </div>
        <div class="stat-card">
            <h3>Placement Enrollments</h3>
            <div class="number">{{ $placements->count() }}</div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('courses')">📚 Courses</button>
        <button class="tab-btn" onclick="switchTab('videos')">🎬 Videos</button>
        <button class="tab-btn" onclick="switchTab('registrations')">👥 Registrations</button>
        <button class="tab-btn" onclick="switchTab('placements')">🎯 Placements</button>
    </div>

    <!-- Courses Tab -->
    <div id="courses" class="tab-content active">
        <div class="action-bar">
            <input type="text" class="search-box" placeholder="Search courses..." onkeyup="searchTable(this, 'coursesTable')">
            <a href="{{ route('admin.courses.create') }}" class="btn-add">
                ➕ Add New Course
            </a>
        </div>

        <div class="data-table">
            <table id="coursesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Videos</th>
                        <th>Students</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td>{{ $course->id }}</td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->videos->count() }} videos</td>
                            <td>{{ $course->registrations->count() }} students</td>
                            <td>
                                <span class="status-badge {{ $course->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $course->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn-sm btn-edit">Edit</a>
                                    <a href="{{ route('admin.courses.videos', $course->id) }}" class="btn-sm btn-view">Videos</a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course->id) }}" style="display: inline;" onsubmit="return confirm('Delete this course and all its videos?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No courses yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Videos Tab -->
    <div id="videos" class="tab-content">
        <div class="action-bar">
            <input type="text" class="search-box" placeholder="Search videos..." onkeyup="searchTable(this, 'videosTable')">
            <a href="{{ route('admin.videos.create') }}" class="btn-add">
                ➕ Add New Video
            </a>
        </div>

        <div class="data-table">
            <table id="videosTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Video Title</th>
                        <th>Course</th>
                        <th>Order</th>
                        <th>Access</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allVideos as $video)
                        <tr>
                            <td>{{ $video->id }}</td>
                            <td>{{ $video->title }}</td>
                            <td>{{ $video->course->name }}</td>
                            <td>{{ $video->order }}</td>
                            <td>
                                <span class="status-badge {{ $video->is_free ? 'status-active' : 'status-inactive' }}">
                                    {{ $video->is_free ? 'Free' : 'Locked' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.videos.edit', $video->id) }}" class="btn-sm btn-edit">Edit</a>
                                    <form method="POST" action="{{ route('admin.videos.destroy', $video->id) }}" style="display: inline;" onsubmit="return confirm('Delete this video?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No videos yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Registrations Tab -->
    <div id="registrations" class="tab-content">
        <div class="action-bar">
            <input type="text" class="search-box" placeholder="Search registrations..." onkeyup="searchTable(this, 'registrationsTable')">
        </div>

        <div class="data-table">
            <table id="registrationsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        <tr>
                            <td>{{ $reg->id }}</td>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->email }}</td>
                            <td>{{ $reg->course->name }}</td>
                            <td>
                                <span class="status-badge status-{{ $reg->status }}">
                                    {{ ucfirst($reg->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button onclick="toggleDetails({{ $reg->id }})" class="btn-sm btn-view">Details</button>
                                    <a href="{{ route('admin.downloadFile', ['type' => 'resume', 'id' => $reg->id]) }}" class="btn-sm btn-edit">Resume</a>
                                    @if(!$reg->course_unlocked)
                                        <form method="POST" action="{{ route('admin.unlockCourse', $reg->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn-sm btn-add" style="padding: 0.4rem 0.8rem;">Unlock</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr id="details-{{ $reg->id }}" style="display: none;">
                            <td colspan="6" style="background: var(--light); padding: 1.5rem;">
                                <strong>CGPA:</strong> {{ $reg->cgpa ?? 'N/A' }}<br>
                                <strong>Expected CTC:</strong> {{ $reg->expected_ctc ? '₹' . number_format($reg->expected_ctc, 2) . ' LPA' : 'N/A' }}<br>
                                <strong>Goal:</strong> {{ $reg->goal ?? 'N/A' }}<br>
                                <strong>Registered:</strong> {{ $reg->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No registrations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Placements Tab -->
    <div id="placements" class="tab-content">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($placements as $placement)
                        <tr>
                            <td>{{ $placement->id }}</td>
                            <td>{{ $placement->email }}</td>
                            <td>{{ $placement->phone }}</td>
                            <td>₹{{ number_format($placement->amount, 2) }}</td>
                            <td>{{ $placement->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 2rem;">No placement enrollments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>

<script>
    function switchTab(tabName) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        
        document.getElementById(tabName).classList.add('active');
        event.target.classList.add('active');
    }

    function toggleDetails(id) {
        const detailsRow = document.getElementById('details-' + id);
        detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' : 'none';
    }

    function searchTable(input, tableId) {
        const filter = input.value.toUpperCase();
        const table = document.getElementById(tableId);
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            let found = false;
            const td = tr[i].getElementsByTagName('td');
            
            for (let j = 0; j < td.length; j++) {
                if (td[j]) {
                    const txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }
            
            tr[i].style.display = found ? '' : 'none';
        }
    }
</script>
@endsection
