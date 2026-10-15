@extends('layouts.master')

@section('title', $mode === 'create' ? 'Add Supplier' : 'Edit Supplier')

@section('content')
    <section class="section">
        <ul class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.buysell') }}"><i class="fas fa-home"></i></a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.supplier.index') }}">Suppliers</a></li>
            <li class="breadcrumb-item active">{{ $mode === 'create' ? 'Add' : 'Edit' }}</li>
        </ul>

        <form method="POST" action="{{ $mode === 'create' ? route('admin.supplier.store') : route('admin.supplier.update', $supplier) }}">
            @csrf
            @if ($mode === 'edit') @method('PUT') @endif
            <div class="card">
                <div class="card-header"><h4 class="mb-0">{{ $mode === 'create' ? 'Add supplier' : 'Edit supplier' }}</h4></div>
                <div class="card-body"><div class="row">
                    @foreach ([
                        'customer_code' => ['Supplier code', 'text', true],
                        'name' => ['Supplier name', 'text', true],
                        'phone' => ['Phone', 'tel', true],
                        'email' => ['Email', 'email', false],
                        'address' => ['Address', 'text', false],
                        'city' => ['City', 'text', false],
                        'country' => ['Country', 'text', false],
                        'trn_no' => ['TRN number', 'text', false],
                        'trade_license' => ['Trade license', 'text', false],
                    ] as $field => [$label, $inputType, $required])
                        <div class="col-md-4"><div class="form-group"><label for="{{ $field }}">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label><input type="{{ $inputType }}" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" value="{{ old($field, $supplier->$field) }}" @required($required)>@error($field)<div class="invalid-feedback">{{ $message }}</div>@enderror</div></div>
                    @endforeach
                    <div class="col-md-4"><div class="form-group"><label for="status">Status <span class="text-danger">*</span></label><select class="form-control" id="status" name="status" required><option value="activated" @selected(old('status', $supplier->status ?: 'activated') === 'activated')>Active</option><option value="deactived" @selected(old('status', $supplier->status) === 'deactived')>Inactive</option></select></div></div>
                </div></div>
                <div class="card-footer text-right"><a href="{{ route('admin.supplier.index') }}" class="btn btn-outline-secondary mr-2">Cancel</a><button class="btn btn-primary" type="submit">{{ $mode === 'create' ? 'Create supplier' : 'Save changes' }}</button></div>
            </div>
        </form>
    </section>
@stop
