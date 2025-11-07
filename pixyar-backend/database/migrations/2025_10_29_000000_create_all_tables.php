<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('plan', ['free', 'pro', 'business'])->default('free');
            $table->timestamp('last_login_at')->nullable();
            $table->string('signup_ip')->nullable();
            $table->enum('status', ['active', 'suspended'])->default('active');
            $table->timestamps();
        });

        // instagram_profiles
        Schema::create('instagram_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('username')->unique();
            $table->string('full_name')->nullable();
            $table->string('profile_pic')->nullable();
            $table->text('biography')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->default(0);
            $table->integer('posts_count')->default(0);
            $table->string('country')->nullable();
            $table->string('language')->nullable();
            $table->enum('account_type', ['personal','business','creator'])->default('personal');
            $table->float('engagement_rate')->nullable();
            $table->float('avg_likes')->nullable();
            $table->float('avg_comments')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });

        // instagram_profile_snapshots
        Schema::create('instagram_profile_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('instagram_profiles')->onDelete('cascade');
            $table->integer('followers_count');
            $table->integer('following_count');
            $table->integer('posts_count');
            $table->float('avg_likes');
            $table->float('avg_comments');
            $table->float('engagement_rate');
            $table->timestamp('collected_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // instagram_posts
        Schema::create('instagram_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('instagram_profiles')->onDelete('cascade');
            $table->string('shortcode')->unique();
            $table->enum('media_type', ['image','video','carousel'])->default('image');
            $table->string('media_url');
            $table->string('thumbnail_url')->nullable();
            $table->text('caption')->nullable();
            $table->json('hashtags')->nullable();
            $table->json('mentions')->nullable();
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('views_count')->default(0);
            $table->boolean('is_sponsored')->default(false);
            $table->timestamp('posted_at')->nullable();
            $table->timestamp('fetched_at')->nullable();
            $table->timestamps();
        });

        // instagram_comments
        Schema::create('instagram_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('instagram_posts')->onDelete('cascade');
            $table->string('username');
            $table->text('text');
            $table->float('sentiment_score')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // post_insights
        Schema::create('post_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained('instagram_posts')->onDelete('cascade');
            $table->float('engagement_rate')->nullable();
            $table->integer('caption_length')->nullable();
            $table->integer('hashtags_count')->nullable();
            $table->integer('mentions_count')->nullable();
            $table->integer('best_posting_hour')->nullable();
            $table->enum('performance_label', ['high','medium','low'])->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // scheduled_jobs
        Schema::create('scheduled_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('job_type', ['fetch_profile','fetch_posts','analyze']);
            $table->enum('status', ['pending','running','done','failed'])->default('pending');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->text('message')->nullable();
            $table->timestamps();
        });

        // reports
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('profile_id')->constrained('instagram_profiles')->onDelete('cascade');
            $table->enum('type', ['weekly','monthly']);
            $table->string('file_path');
            $table->timestamp('generated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // analytics_cache
        Schema::create('analytics_cache', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('instagram_profiles')->onDelete('cascade');
            $table->string('type');
            $table->json('payload');
            $table->timestamp('calculated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // subscriptions
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('plan', ['free','pro','business']);
            $table->integer('price');
            $table->enum('status', ['active','canceled','expired']);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamps();
        });

        // activity_logs
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action');
            $table->json('metadata')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });

        // api_requests
        Schema::create('api_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('endpoint');
            $table->integer('response_time_ms')->nullable();
            $table->integer('status_code')->nullable();
            $table->integer('response_size')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('api_requests');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('analytics_cache');
        Schema::dropIfExists('reports');
        Schema::dropIfExists('scheduled_jobs');
        Schema::dropIfExists('post_insights');
        Schema::dropIfExists('instagram_comments');
        Schema::dropIfExists('instagram_posts');
        Schema::dropIfExists('instagram_profile_snapshots');
        Schema::dropIfExists('instagram_profiles');
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();
    }
};
