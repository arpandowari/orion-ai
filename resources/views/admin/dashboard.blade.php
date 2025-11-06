@extends('layouts.admin')

@section('title', 'Admin Dashboard - ORION AI')

@section('styles')
<style>
    .dashboard-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }

    .tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
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

    .data-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    table {
        width: 100%;
        border-collapse: collapse;
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
    }

    .details-row {
        background: var(--light);
        padding: 1rem;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .detail-item {
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
    }

    .detail-item strong {
        color: var(--primary);
        display: block;
        margin-bottom: 0.25rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Manage student registrations and enrollments</p>
    </div>

    <div class="tabs">
        <button class="tab-btn active" onclick="switchTab('registrations')">Course Registrations</button>
        <button class="tab-btn" onclick="switchTab('placements')">Placement Enrollments</button>
    </div>

    <div id="registrations" class="tab-content active">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>CGPA</th>
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
                            <td>{{ $reg->cgpa ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge status-{{ $reg->status }}">
                                    {{ ucfirst($reg->status) }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <button onclick="toggleDetails({{ $reg->id }})" class="btn btn-outline btn-sm">View Details</button>
                                    <a href="{{ route('admin.downloadFile', ['type' => 'resume', 'id' => $reg->id]) }}" class="btn btn-primary btn-sm">Resume</a>
                                    <a href="{{ route('admin.downloadFile', ['type' => 'marksheet', 'id' => $reg->id]) }}" class="btn btn-primary btn-sm">Marksheet</a>
                                    
                                    @if(!$reg->course_unlocked)
                                        <form method="POST" action="{{ route('admin.unlockCourse', $reg->id) }}" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">Unlock Course</button>
                                        </form>
                                    @else
                                        <span class="status-badge status-verified">Unlocked</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <tr id="details-{{ $reg->id }}" style="display: none;">
                            <td colspan="7">
                                <div class="details-row">
                                    <div class="details-grid">
                                        <div class="detail-item">
                                            <strong>Education:</strong>
                                            {{ $reg->education_details ?? 'Not provided' }}
                                        </div>
                                        <div class="detail-item">
                                            <strong>Goal:</strong>
                                            {{ $reg->goal ?? 'Not provided' }}
                                        </div>
                                        <div class="detail-item">
                                            <strong>Suitable Role:</strong>
                                            {{ $reg->suitable_role ?? 'Not provided' }}
                                        </div>
                                        <div class="detail-item">
                                            <strong>Expected CTC:</strong>
                                            {{ $reg->expected_ctc ? '₹' . number_format($reg->expected_ctc, 2) . ' LPA' : 'Not provided' }}
                                        </div>
                                        <div class="detail-item">
                                            <strong>Extracurricular:</strong>
                                            {{ $reg->extracurricular_activities ?? 'Not provided' }}
                                        </div>
                                        <div class="detail-item">
                                            <strong>Registered:</strong>
                                            {{ $reg->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                    
                                    @if($reg->internship_experience)
                                        <h4 style="margin-top: 1rem; color: var(--primary);">Internship Experience:</h4>
                                        @foreach($reg->internship_experience as $index => $internship)
                                            <div class="detail-item" style="margin-top: 0.5rem;">
                                                <strong>Internship {{ $index + 1 }}:</strong>
                                                Company: {{ $internship['company'] ?? 'N/A' }}<br>
                                                Certificate: {{ $internship['certificate'] ?? 'N/A' }}<br>
                                                Stipend: {{ $internship['stipend'] ?? 'N/A' }}
                                            </div>
                                        @endforeach
                                    @endif

                                    <div style="margin-top: 1rem;">
                                        <form method="POST" action="{{ route('admin.updateStatus', $reg->id) }}" style="display: inline-flex; gap: 0.5rem; align-items: center;">
                                            @csrf
                                            <label><strong>Update Status:</strong></label>
                                            <select name="status" style="padding: 0.5rem; border-radius: 8px; border: 2px solid #e2e8f0;">
                                                <option value="pending" {{ $reg->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="contacted" {{ $reg->status == 'contacted' ? 'selected' : '' }}>Contacted</option>
                                                <option value="verified" {{ $reg->status == 'verified' ? 'selected' : '' }}>Verified</option>
                                            </select>
                                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 2rem;">No registrations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="placements" class="tab-content">
        <div class="data-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Amount</th>
                        <th>Status</th>
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
                            <td>
                                <span class="status-badge status-{{ $placement->status }}">
                                    {{ ucfirst($placement->status) }}
                                </span>
                            </td>
                            <td>{{ $placement->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 2rem;">No placement enrollments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
</script>
@endsection
