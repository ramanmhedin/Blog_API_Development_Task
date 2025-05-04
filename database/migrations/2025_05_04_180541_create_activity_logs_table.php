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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string("performer");
            $table->enum('type_of_action',["CREATE","READ","UPDATE","DELETE"]);
            $table->string("entity_type");
            $table->unsignedBigInteger("entity_id");
            $table->json('changed_fields')->nullable();
            $table->dateTime('timestamp');


            $table->index(['entity_type', 'entity_id']);

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
