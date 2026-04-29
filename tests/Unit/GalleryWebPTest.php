<?php

namespace Tests\Unit;

use App\Models\GalleryFolder;
use App\Models\Image;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalleryWebPTest extends TestCase
{
    use RefreshDatabase;

    public function test_uploaded_image_is_converted_to_webp(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'password'
        ]);

        $folder = GalleryFolder::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => 'Test Folder',
            'slug' => 'test-folder',
            'user_id' => $user->id,
            'is_public' => true,
        ]);

        $this->actingAs($user);

        $file = \Illuminate\Http\UploadedFile::fake()->image('test.jpg', 100, 100);

        $response = $this->post('/gallery/' . $folder->id . '/upload', [
            'images' => [$file]
        ]);

        $response->assertRedirect();

        $image = Image::first();
        $this->assertNotNull($image);
        $this->assertStringEndsWith('.webp', $image->path);
        $this->assertEquals('image/webp', $image->mime_type);
    }
}
