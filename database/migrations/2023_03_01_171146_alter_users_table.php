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
        Schema::table('users', function (Blueprint $table) {
            $table->string("uid");
            $table->string("fonnte_token")->nullable();
            $table->enum("chpass", ["YES", "NO"]);
            $table->enum("status", ["ACTIVE", "INACTIVE"]);
            $table->string("ipaddress", 15)->nullable();
            $table->string("useragent")->nullable();
            $table->foreignId("created_by")->constrained("users");
            $table->foreignId("updated_by")->nullable()->constrained("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
