<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rejects_non_image_uploads(): void
    {
        $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

        $response = $this->post(route('image.upload'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('images', 0);
    }

    public function test_it_rejects_images_larger_than_2mb(): void
    {
        $file = UploadedFile::fake()->image('photo.jpg', 100, 100)->size(2049);

        $response = $this->post(route('image.upload'), [
            'image' => $file,
        ]);

        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('images', 0);
    }
}
