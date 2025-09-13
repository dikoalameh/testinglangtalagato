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
        Schema::create('tbl_research_information', function (Blueprint $table) {
            $table->string('research_info_ID')->primary();
            $table->string('user_ID');
            $table->string('research_title');
            $table->string('research_college');
            $table->string('research_department');
            $table->string('research_Endorsement');
            $table->timestamps();

            $table->foreign('user_ID')
                  ->references('user_ID')
                  ->on('tbl_users')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_research_information');
    }
};
