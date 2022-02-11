<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

class CreateBankStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_statements', function (Blueprint $table) {
            $table->id();
            $table->string('particulars', 500)->nullable();
            $table->string('cheque_no', 15)->nullable();
            $table->date('trans_date');
            $table->decimal('dr_amount', $precision = 15, $scale = 2)->default(0);
            $table->decimal('cr_amount', $precision = 15, $scale = 2)->default(0);
            $table->decimal('balance', $precision = 15, $scale = 2)->default(0);
            $table->char('entry_type', 3)->default('dr.')->nullable();
            $table->unsignedBigInteger('bank_id');
            $table->boolean('is_reconcile')->default(false);
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
        Schema::dropIfExists('bank_statements');
    }
}
