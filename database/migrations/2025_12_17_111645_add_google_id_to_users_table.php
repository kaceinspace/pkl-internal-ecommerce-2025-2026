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
            $table->string('google_id')->nullable()->after('email');
// ↑ google_id = ID unik user dari Google
// nullable()  = Boleh kosong (untuk user yang register manual)
// after()     = Posisikan setelah kolom email

            $table->string('avatar')->nullable()->after('google_id');
// ↑ avatar = URL foto profil dari Google
// nullable() karena user manual mungkin tidak punya avatar

// ================================================
// INDEX UNTUK PERFORMA
// ================================================
            $table->index('google_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['google_id']); // Hapus index dulu
            $table->dropColumn(['google_id', 'avatar']);

        });
    }
};
