<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('particulars', 500);
            $table->string('cheque_no', 15)->nullable();
            $table->date('issue_date');
            $table->decimal('amount', $precision = 15, $scale = 2);
            $table->char('entry_type', 3)->default('LED');
            $table->boolean('is_reconcile')->default(false);
            $table->date('reconciliation_date')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->boolean('excel_upload')->default(false);
            $table->unsignedBigInteger('uploaded_file_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('bank_id')->references('id')->on('banks')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ledgers');
    }
}
