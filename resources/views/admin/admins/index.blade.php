@extends('layouts.admin')

@section('title', 'Admin Management - ORION AI')

@section('styles')
<style>
    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .admin-header h1 {
        color: var(--primary);
        margin: 0;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
    }

    .admin-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: all 0.3s;
    }

    .admin-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }

    .admin-profile {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .admin-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--secondary);
    }

    .admin-avatar-placeholder {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        font-weight: 700;
    }

    .admin-info h3 {
        margin: 0 0 0.25rem 0;
        color: var(--dark);
        font-size: 1.1rem;
    }

    .admin-info p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    .admin-details {
        margin-bottom: 1rem;
        padding: 1rem;
        background: var(--light);
        border-radius: 8px;
    }

    .admin-detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #64748b;
    }

    .admin-detail-item:last-child {
        margin-bottom: 0;
    }

    .admin-detail-item strong {
        color: var(--dark);
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #d1fae5;
        color: #065f46;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .unverified-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: #fee2e2;
        color: #991b1b;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .admin-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-edit {
        background: #3b82f6;
        color: white;
    }

    .btn-edit:hover {
        background: #2563eb;
    }

    .btn-password {
        background: #f59e0b;
        color: white;
    }

    .btn-password:hover {
        background: #d97706;
    }

    .btn-verify {
        background: #10b981;
        color: white;
    }

    .btn-verify:hover {
        background: #059669;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

    .current-user-badge {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="admin-header">
        <h1>Admin Management</h1>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            Add New Admin
        </a>
    </div>

    <div class="admin-grid">
        @forelse($admins as $admin)
            <div class="admin-card">
                <div class="admin-profile">
                    @if($admin->profile_picture)
                        <img src="{{ asset('storage/' . $admin->profile_picture) }}" alt="{{ $admin->name }}" class="admin-avatar">
                    @else
                        <div class="admin-avatar-placeholder">
                            {{ strtoupper(substr($admin->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="admin-info">
                        <h3>
                            {{ $admin->name }}
                            @if($admin->id === auth()->id())
                                <span class="current-user-badge">You</span>
                            @endif
                        </h3>
                        <p>{{ $admin->email }}</p>
                    </div>
                </div>

                <div class="admin-details">
                    @if($admin->phone)
                        <div class="admin-detail-item">
                            <strong>Phone:</strong> {{ $admin->phone }}
                        </div>
                    @endif
                    <div class="admin-detail-item">
                        <strong>Email Status:</strong>
                        @if($admin->email_verified_at)
                            <span class="verified-badge">Verified</span>
                        @else
                            <span class="unverified-badge">Not Verified</span>
                        @endif
                    </div>
                    <div class="admin-detail-item">
                        <strong>Joined:</strong> {{ $admin->created_at->format('M d, Y') }}
                    </div>
                </div>

                <div class="admin-actions">
                    <a href="{{ route('admin.admins.edit', $admin->id) }}" class="btn-sm btn-edit">
                        Edit
                    </a>
                    <a href="{{ route('admin.admins.change-password', $admin->id) }}" class="btn-sm btn-password">
                        Password
                    </a>
                    @if(!$admin->email_verified_at)
                        <form method="POST" action="{{ route('admin.admins.send-verification', $admin->id) }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-sm btn-verify">
                                Verify Email
                            </button>
                        </form>
                    @endif
                    @if($admin->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.admins.destroy', $admin->id) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-sm btn-delete">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                <p style="font-size: 1.2rem; color: #64748b;">No admins found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
