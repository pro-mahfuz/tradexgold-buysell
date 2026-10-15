<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    private const TYPE = 'supplier';

    public function index()
    {
        $suppliers = Customer::query()
            ->where('type', self::TYPE)
            ->latest('id')
            ->get();

        return view('admin.supplier.customers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.supplier.customers.form', [
            'supplier' => new Customer(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['type'] = 'supplier';
        $data['status'] = $data['status'] ?? 'activated';

        Customer::create($data);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier created successfully.');
    }

    public function edit(Customer $supplier)
    {
        $this->ensureSupplier($supplier);

        return view('admin.supplier.customers.form', compact('supplier') + ['mode' => 'edit']);
    }

    public function update(Request $request, Customer $supplier)
    {
        $this->ensureSupplier($supplier);
        $data = $this->validated($request, $supplier);
        $data['type'] = 'supplier';

        $supplier->update($data);

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier updated successfully.');
    }

    private function validated(Request $request, ?Customer $supplier = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'customer_code' => [
                'required', 'string', 'max:255',
                Rule::unique('accounts', 'customer_code')->ignore($supplier?->id),
            ],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'trn_no' => ['nullable', 'string', 'max:255'],
            'trade_license' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['activated', 'deactived'])],
        ]);
    }

    private function ensureSupplier(Customer $supplier): void
    {
        abort_unless($supplier->type === self::TYPE, 404);
    }
}
