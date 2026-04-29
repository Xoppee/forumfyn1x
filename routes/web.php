<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\FollowsController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMessagesController;
use App\Http\Controllers\UserVerificationController;
use App\Http\Controllers\TopicTemplatesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\GalleryController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/p/{page:slug}', [PagesController::class, 'show'])->name('page.show');
Route::get('/auth', [AuthController::class, 'index'])->name('login');
Route::post('/auth/register', [AuthController::class, 'register'])->name('register');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login.submit');

// Public API
Route::get('/api/templates', [TopicTemplatesController::class, 'index']);
Route::get('/api/templates/{id}', [TopicTemplatesController::class, 'show']);

// Public pages
Route::get('/profile/{u}', [ProfileController::class, 'index'])->name('profile');
Route::get('/topics/{t}', [TopicController::class, 'index'])->name('topics.show');
Route::get('/topics', [TopicController::class, 'list'])->name('topics.list');
Route::get('/search', [SearchController::class, 'index'])->name('search');

Route::middleware('auth')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    // Follow/Unfollow
    Route::post('/users/{user}/follow', [FollowsController::class, 'follow'])->name('users.follow');
    Route::delete('/users/{user}/follow', [FollowsController::class, 'unfollow'])->name('users.unfollow');
    Route::get('/users/{user}/followers', [FollowsController::class, 'followers']);
    Route::get('/users/{user}/following', [FollowsController::class, 'following']);

    // Admin routes - require admin middleware
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
        Route::get('/admin/pages', [PagesController::class, 'index'])->name('admin.pages.list');
    Route::get('/admin/pages/create', [PagesController::class, 'create'])->name('admin.pages.create');
    Route::post('/admin/pages', [PagesController::class, 'store'])->name('admin.pages.store');
    Route::get('/admin/pages/{page}/edit', [PagesController::class, 'edit'])->name('admin.pages.edit');
    Route::put('/admin/pages/{page}', [PagesController::class, 'update'])->name('admin.pages.update');
    Route::delete('/admin/pages/{page}', [PagesController::class, 'destroy'])->name('admin.pages.destroy');

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/admin/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');

    Route::get('/admin/topics', [AdminController::class, 'topics'])->name('admin.topics');
    Route::post('/admin/topics', [AdminController::class, 'storeTopic'])->name('admin.topics.store');
    Route::post('/admin/topics/{topic}/toggle', [AdminController::class, 'toggleTopic'])->name('admin.topics.toggle');
    Route::delete('/admin/topics/{topic}', [AdminController::class, 'deleteTopic'])->name('admin.topics.delete');

    Route::post('/admin/posts/{post}/toggle', [AdminController::class, 'togglePost'])->name('admin.posts.toggle');
    Route::delete('/admin/posts/{post}', [AdminController::class, 'deletePost'])->name('admin.posts.delete');

    Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
    Route::post('/admin/roles', [AdminController::class, 'storeRole'])->name('admin.roles.store');
    Route::post('/admin/roles/{role}/toggle', [AdminController::class, 'toggleRole'])->name('admin.roles.toggle');
    Route::delete('/admin/roles/{role}', [AdminController::class, 'deleteRole'])->name('admin.roles.delete');
    Route::post('/admin/users/{user}/roles', [AdminController::class, 'assignRole'])->name('admin.users.assignRole');
    Route::delete('/admin/users/{user}/roles/{role}', [AdminController::class, 'removeRole'])->name('admin.users.removeRole');

    Route::get('/admin/images', [AdminController::class, 'images'])->name('admin.images');
    Route::delete('/admin/images/{image}', [AdminController::class, 'deleteImage'])->name('admin.images.delete');

    Route::get('/admin/archives', [AdminController::class, 'archives'])->name('admin.archives');
    Route::delete('/admin/archives/{archive}', [AdminController::class, 'deleteArchive'])->name('admin.archives.delete');
    }); // end admin middleware group

    // Groups API
    Route::get('/api/groups', [GroupController::class, 'index']);
    Route::post('/api/groups', [GroupController::class, 'store']);
    Route::get('/api/groups/{group}', [GroupController::class, 'show']);
    Route::put('/api/groups/{group}', [GroupController::class, 'update']);
    Route::delete('/api/groups/{group}', [GroupController::class, 'destroy']);
    Route::post('/api/groups/{group}/join', [GroupController::class, 'join']);
    Route::delete('/api/groups/{group}/leave', [GroupController::class, 'leave']);
    Route::get('/api/groups/{group}/members', [GroupController::class, 'members']);
    Route::get('/api/groups/{group}/pending', [GroupController::class, 'pendingMembers']);
    Route::post('/api/groups/{group}/members/{user}/approve', [GroupController::class, 'approveMember']);
    Route::post('/api/groups/{group}/members/{user}/ban', [GroupController::class, 'banMember']);
    Route::post('/api/groups/{group}/roles', [GroupController::class, 'createRole']);
    Route::put('/api/groups/{group}/roles/{role}', [GroupController::class, 'updateRole']);
    Route::delete('/api/groups/{group}/roles/{role}', [GroupController::class, 'deleteRole']);

    // Groups Web
    Route::get('/groups', [GroupController::class, 'webIndex'])->name('groups.index');
    Route::get('/groups/discover', [GroupController::class, 'webDiscover'])->name('groups.discover');
    Route::get('/groups/create', [GroupController::class, 'webCreate'])->name('groups.create');
    Route::get('/groups/{group}', [GroupController::class, 'webShow']);
    Route::get('/groups/{group}/topics/create', [TopicController::class, 'createForGroup']);
    Route::post('/groups/{group}/topics', [TopicController::class, 'storeForGroup']);
    Route::get('/verification', [UserVerificationController::class, 'webIndex']);

    // Group Messages
    Route::get('/api/groups/{group}/messages', [GroupMessagesController::class, 'messages']);
    Route::post('/api/groups/{group}/messages', [GroupMessagesController::class, 'send']);
    Route::get('/api/groups/{group}/messages/latest', [GroupMessagesController::class, 'latest']);
    Route::delete('/api/groups/{group}/messages/{message}', [GroupMessagesController::class, 'delete']);

    // User Verification
    Route::get('/api/verification/status', [UserVerificationController::class, 'status']);
    Route::post('/api/verification/request', [UserVerificationController::class, 'request']);
    Route::get('/api/verification/progress', [UserVerificationController::class, 'progress']);

    // Topic Templates Admin
    Route::put('/api/templates', [TopicTemplatesController::class, 'update']);
    Route::post('/api/templates', [TopicTemplatesController::class, 'add']);

    // Topics - Admin only creation
    Route::middleware('admin')->group(function () {
        Route::post('/topics', [TopicController::class, 'store'])->name('topics.store');
        Route::get('/create/topic', [TopicController::class, 'create'])->name('topics.create');
    });

    // Reactions
    Route::post('/reactions/toggle', [ReactionController::class, 'toggle'])->name('reactions.toggle');
    Route::get('/reactions', [ReactionController::class, 'index'])->name('reactions.index');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('/blog/{slug}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{slug}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{slug}', [BlogController::class, 'destroy'])->name('blog.destroy');

    // Profile
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Blog Toggle
    Route::post('/profile/blog/enable', [ProfileController::class, 'enableBlog'])->name('profile.blog.enable');
    Route::post('/profile/blog/disable', [ProfileController::class, 'disableBlog'])->name('profile.blog.disable');

    // Posts
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Gallery
    Route::get('/gallery', [GalleryController::class, 'index']);
    Route::post('/gallery/folders', [GalleryController::class, 'createFolder']);
    Route::get('/gallery/{folder}', [GalleryController::class, 'folder']);
    Route::post('/gallery/{folder}/upload', [GalleryController::class, 'upload']);
    Route::delete('/gallery/folders/{folder}', [GalleryController::class, 'deleteFolder']);
    Route::delete('/gallery/images/{image}', [GalleryController::class, 'deleteImage']);

    // Gallery API
    Route::get('/api/gallery', [GalleryController::class, 'apiIndex']);
    Route::post('/api/gallery/upload', [GalleryController::class, 'apiUpload']);
});
