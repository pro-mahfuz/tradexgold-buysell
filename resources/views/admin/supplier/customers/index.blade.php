@extends('layouts.master')

@section('title', 'Supplier List')

@section('content')
    <section class="section">
        <ul class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.buysell') }}"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item active">Suppliers</li>
        </ul>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div><h4 class="mb-0">Suppliers</h4><small class="text-muted">Supplier records are stored in the accounts table.</small></div>
                <a href="{{ route('admin.supplier.create') }}" class="btn btn-primary"><i class="fa fa-plus mr-1"></i>Add supplier</a>
            </div>
            <div class="card-body">
                @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                <div class="table-responsive">
                    <table id="supplier-table" class="table table-hover mb-0" style="width:100%">
                        <thead><tr><th>#</th><th>Code</th><th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th>Status</th><th>Action</th></tr></thead>
                        <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $supplier->customer_code }}</td>
                                    <td>{{ $supplier->name }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email ?: '—' }}</td>
                                    <td>{{ collect([$supplier->address, $supplier->city, $supplier->country])->filter()->join(', ') ?: '—' }}</td>
                                    <td><span class="badge badge-{{ $supplier->status === 'activated' ? 'success' : 'warning' }}">{{ ucfirst($supplier->status) }}</span></td>
                                    <td><a href="{{ route('admin.supplier.edit', $supplier) }}" class="btn btn-outline-info btn-sm">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop

@section('page_js')
    <script>$(function () { $('#supplier-table').DataTable({ responsive: true, pageLength: 25, order: [[2, 'asc']] }); });</script>
@endsection
