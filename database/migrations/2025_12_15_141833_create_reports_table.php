<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->enum('report_type', ['lost', 'found']);

            $table->string('item_name');
            $table->text('description');
            $table->string('location');

            $table->string('contact_info')->nullable();

            $table->date('date_lost_found');

            $table->string('photo')->nullable();

            $table->string('verification_question')->nullable();

            $table->enum('status', ['open', 'resolved', 'returned'])
                  ->default('open');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
