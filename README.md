# Image Uploader

A small Laravel app for uploading images, resizing them to fit within 1024×1024, and storing them in Azure Blob Storage (falling back to local disk storage if Azure is unreachable). There is also a direct offline mode that can be used.

I chose Laravel because I'm familiar with it and it let me move quickly. Routing, validation, Eloquent, Blade, and the filesystem abstraction (which made swapping between the Azure and local disks straightforward) all came built in.

I used intervention to resize any images that are bigger than 1024x1024px.
I used **[azure-oss/storage-blob-laravel](https://github.com/Azure-OSS/azure-storage-blob-laravel-php)** to help me connect to the azure container.
I used tailwind for my frontend styling.
SQLlite was used for the database, for simplicity. No need to spin up a DB server aswell for this task.
I use aos to fade the images in, as a bit of cleanup.

Before starting the project, I used Excalidraw to draw up a quick system design diagram.
<br>
<img src="APL Task System Design.png" alt="System design diagram" width="1000">

## Improvements

I originally wanted to have User authentication, so then the images are linked to the user. But I felt that got out of the scope of the project, so I left it out. If I had more time, then User authentication would be present.

I have also written a couple of automated tests for the Image upload functionality. In a bigger project with more time, there would be more written tests.

Right now, it's not handling the scenario for if the Azure connection is lost after loading the website. So if the user tries to delete an image that's in Azure, when it's not connected, the page will hang.

I would also create some front-end validation as an improvement. So this would prevent the user from only seeing errors after clicking 'Upload'.

## Packages Used

- **[intervention/image](https://image.intervention.io/)** - resizes uploaded images to fit within 1024×1024 before storing them.
- **[azure-oss/storage-blob-laravel](https://github.com/Azure-OSS/azure-storage-blob-laravel-php)** - Flysystem/Laravel filesystem driver for Azure Blob Storage, registered as the `azure` disk.
- **[tailwindcss](https://tailwindcss.com/)** - utility-first CSS for styling the upload form and image lists.

## Setup

1. **Install PHP dependencies**

   ```bash
   composer install
   ```

2. **Install frontend dependencies**

   ```bash
   npm install
   ```

3. **Create the environment file**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Set up `APP_URL`**

   Make sure `APP_URL` in `.env` matches how you actually access the site locally (e.g. `http://image_uploader_task.test` if served via Laravel Herd, or `http://localhost:8000` if using `php artisan serve`). This is used to build local image URLs correctly.

5. **Create the database**

   This project uses SQLite by default.

   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

6. **Configure Azure Blob Storage**

   Add your connection string and container name to `.env`:

   ```
   AZURE_STORAGE_CONNECTION_STRING="<your connection string>"
   AZURE_STORAGE_CONTAINER=<your container name>
   ```

   If this isn't configured (or the connection fails), uploads automatically fall back to local storage under `storage/app/public/images`. In that case, make sure the storage symlink exists:

   ```bash
   php artisan storage:link
   ```

7. **Build frontend assets**

   ```bash
   npm run build
   ```