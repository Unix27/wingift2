<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFailedTransactionsNumberToCloudPaymentsSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cloudPaymentsSubscriptions', function (Blueprint $table) {
            $table->integer('failedTransactionsNumber')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cloudPaymentsSubscriptions', function (Blueprint $table) {
            $table->dropColumn('failedTransactionsNumber');
        });
    }
}
