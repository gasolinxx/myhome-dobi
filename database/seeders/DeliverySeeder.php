<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the specific image you want to copy
        $imageToStore = 'pic4.jpeg';

        // Store the specific image
        $this->storeImage($imageToStore);


        DB::table('deliveries')->insert([

            [
                'order_id' => 1,
                'pickup_id' => 6,
                'deliver_id' => NULL,
                'delivery_date' => NULL,
                'proof_pickup' => NULL,
                'proof_deliver' =>  NULL,
                'created_at' => now(),
                'updated_at' => null,
            ],

            [
                'order_id' => 2,
                'pickup_id' => 7,
                'deliver_id' => NULL,
                'delivery_date' => NULL,
                'proof_pickup' => $imageToStore,
                'proof_deliver' =>  NULL,
                'created_at' => now(),
                'updated_at' => null,
            ],

            [
                'order_id' => 4,
                'pickup_id' => 6,
                'deliver_id' => NULL,
                'delivery_date' => NULL,
                'proof_pickup' => $imageToStore,
                'proof_deliver' =>  NULL,
                'created_at' => now(),
                'updated_at' => NULL,
            ],

        ]);
    }
    private function storeImage($image)
    {
        $sourceImagePath = database_path("seeders/images/{$image}"); // Path to the source image
        $destinationPath = 'banner'; // Directory in public storage
    
        // Check if the source image exists
        if (File::exists($sourceImagePath)) {
            // Ensure the destination directory exists
            if (!Storage::disk('public')->exists($destinationPath)) {
                Storage::disk('public')->makeDirectory($destinationPath);
            }
    
            // Copy the image to the storage
            Storage::disk('public')->putFileAs($destinationPath, new File($sourceImagePath), $image);
            
            return true; // Indicate success
        } else {
            // Log an error if the source image does not exist
            \Log::error("Source image does not exist: {$sourceImagePath}");
            return false; // Indicate failure
        }
    }
}
