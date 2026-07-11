<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('value_vi')->nullable()->after('value');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('title_vi')->nullable()->after('title');
            $table->text('description_vi')->nullable()->after('description');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('title_vi')->nullable()->after('title');
            $table->text('description_vi')->nullable()->after('description');
        });

        Schema::table('resume_entries', function (Blueprint $table) {
            $table->string('period_vi')->nullable()->after('period');
            $table->string('title_vi')->nullable()->after('title');
            $table->text('description_vi')->nullable()->after('description');
        });

        Schema::table('achievements', function (Blueprint $table) {
            $table->string('label_vi')->nullable()->after('label');
        });
    }

    public function down(): void
    {
        Schema::table('settings', fn (Blueprint $table) => $table->dropColumn('value_vi'));
        Schema::table('projects', fn (Blueprint $table) => $table->dropColumn(['title_vi', 'description_vi']));
        Schema::table('services', fn (Blueprint $table) => $table->dropColumn(['title_vi', 'description_vi']));
        Schema::table('resume_entries', fn (Blueprint $table) => $table->dropColumn(['period_vi', 'title_vi', 'description_vi']));
        Schema::table('achievements', fn (Blueprint $table) => $table->dropColumn('label_vi'));
    }
};
