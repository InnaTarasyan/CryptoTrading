<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Personal Information
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('username')->nullable()->unique()->after('last_name');
            $table->string('phone')->nullable()->after('username');
            $table->text('bio')->nullable()->after('phone');
            $table->string('avatar')->nullable()->after('bio');
            
            // Contact Information
            $table->enum('email_notifications', ['all', 'important', 'none'])->default('all')->after('avatar');
            
            // Location
            $table->string('country')->nullable()->after('email_notifications');
            $table->string('timezone')->nullable()->after('country');
            
            // Social Media
            $table->string('twitter')->nullable()->after('timezone');
            $table->string('linkedin')->nullable()->after('twitter');
            $table->string('github')->nullable()->after('linkedin');
            $table->string('website')->nullable()->after('github');
            
            // Privacy Settings
            $table->boolean('profile_public')->default(false)->after('website');
            $table->boolean('show_email')->default(false)->after('profile_public');
            $table->boolean('show_location')->default(false)->after('show_email');
            $table->boolean('show_social')->default(false)->after('show_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'username', 'phone', 'bio', 'avatar',
                'email_notifications', 'country', 'timezone', 'twitter', 'linkedin',
                'github', 'website', 'profile_public', 'show_email', 'show_location', 'show_social'
            ]);
        });
    }
}
