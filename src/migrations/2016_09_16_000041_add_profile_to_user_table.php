<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration as BaseMigration;

class AddProfileToUserTable extends BaseMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users') &&
            !Schema::hasColumns('users', [
            'phone',
            'photo_url'
        ]))
        {
            Schema::table('users', function(Blueprint $table)
            {
                $table->string('phone')->default('');
                $table->string('photo_url', 1024)->default('');
                $table->integer('status')->default(1);
                $table->string('type')->default('User');
                $table->string('fp')->default('');
                $table->string('ip')->default('');
                $table->string('reference_type')->default('');
                $table->integer('reference_id')->default(0);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(Schema::hasTable('users'))
        {
            Schema::table('users', function(Blueprint $table)
            {
                $table->dropIfExists('phone');
                $table->dropIfExists('photo_url');
                $table->dropIfExists('status');
                $table->dropIfExists('type');
                $table->dropIfExists('fp');
                $table->dropIfExists('ip');
                $table->dropIfExists('reference_type');
                $table->dropIfExists('reference_id');
            });
        }
    }
}
