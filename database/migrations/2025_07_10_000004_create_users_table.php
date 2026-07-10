<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        // Users table already exists (created by default Laravel migration).
        // Role column added manually via: ALTER TABLE users ADD COLUMN role VARCHAR NOT NULL DEFAULT 'viewer'
    }

    public function down(): void
    {
        //
    }
};
