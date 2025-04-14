<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tactical\OpenAiTools\Models\Assistant;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create((new Assistant)->getTable(), function (Blueprint $table) {
            $table->id();
            $table->string('open_ai_assistant_id')->nullable();
            $table->string('open_ai_vector_store_id')->nullable();
            $table->foreignId('assistable_id')->nullable();
            $table->string('assistable_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists((new Assistant)->getTable());
    }
};
