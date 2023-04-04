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
        Schema::table('posts',function(Blueprint $table){
            $table->text('post_tags')->nullable()->after('post_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Scshema::table('posts',function(Blueprint $table){
            $table->dropColumn('post_tags');
        });
    }
};
