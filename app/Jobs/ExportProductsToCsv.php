<?php

namespace App\Jobs;

use App\Mail\ProductExportMail;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ExportProductsToCsv implements ShouldQueue
{
    use Queueable;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {
        $fileName = 'products-' . now()->timestamp . '.csv';
        $filePath = storage_path('app/' . $fileName);

        // Open a file for writing
        $file = fopen($filePath, 'w');

        // Write the header row
        fputcsv($file, ['ID', 'Name', 'Description', 'Price', 'Quantity', 'Category']);

        // Fetch and write product data
        Product::with('category')->chunk(100, function ($products) use ($file) {
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->description,
                    $product->price,
                    $product->quantity,
                    $product->category->name ?? 'Uncategorized',
                ]);
            }
        });

        fclose($file);

        // Attach the file to the user using Spatie Media Library
        // Send the email with the CSV file attached
        Mail::to($this->user->email)->send(new ProductExportMail($filePath));

        // Remove the temporary file
        Storage::delete($fileName);
    }
}
