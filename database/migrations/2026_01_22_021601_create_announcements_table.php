<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['info', 'warning', 'danger', 'success', 'primary'])->default('info');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->boolean('show_on_frontend')->default(false);
            $table->boolean('show_as_modal')->default(false);
            $table->boolean('modal_show_once')->default(false);
            $table->integer('modal_width')->nullable()->comment('Width in pixels or percentage');
            $table->integer('sort_order')->default(0);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->json('modal_settings')->nullable()->comment('Modal position, animation, etc');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['status', 'show_on_frontend', 'show_as_modal']);
            $table->index('sort_order');
        });
    }

    public function down()
    {
        Schema::dropIfExists('announcements');
    }
};