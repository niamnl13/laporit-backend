<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->enum('priority', ['rendah', 'normal', 'tinggi', 'gawat'])->default('normal')->after('status');
            $table->foreignId('operator_id')->nullable()->constrained('users')->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['operator_id']);
            $table->dropColumn('operator_id');
            $table->dropColumn('priority');
        });
    }
};
