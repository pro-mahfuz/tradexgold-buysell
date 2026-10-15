<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('customers') && ! Schema::hasTable('accounts')) {
            Schema::rename('customers', 'accounts');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('accounts') && ! Schema::hasTable('customers')) {
            Schema::rename('accounts', 'customers');
        }
    }
};
