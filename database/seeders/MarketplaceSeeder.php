<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Enquiry;
use App\Models\Message;

class MarketplaceSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::factory()->create([
            'email' => 'admin@test.com',
            'role' => User::ROLE_ADMIN
        ]);

        // Providers
        $providers = User::factory()
            ->count(50)
            ->create(['role' => User::ROLE_PROVIDER]);

        // Customers
        $customers = User::factory()
            ->count(100)
            ->create(['role' => User::ROLE_CUSTOMER]);

        // Categories
        $categories = Category::factory()->count(10)->create();

        // Listings (Bulk Insert Properly)
        $listings = Listing::factory()
            ->count(1000)
            ->make()
            ->each(function ($listing) use ($providers, $categories) {
                $listing->user_id = $providers->random()->id;
                $listing->category_id = $categories->random()->id;
            });

        Listing::insert($listings->toArray()); // faster than save()

        // Fetch only approved listings for enquiries
        $approvedListings = Listing::where('status', Listing::STATUS_APPROVED)
            ->inRandomOrder()
            ->limit(200)
            ->get();

        foreach ($approvedListings as $listing) {

            $customer = $customers->random();

            $enquiry = Enquiry::create([
                'listing_id' => $listing->id,
                'customer_id' => $customer->id,
                'provider_id' => $listing->user_id,
                'status' => Enquiry::STATUS_OPEN
            ]);

            Message::factory()
                ->count(3)
                ->create([
                    'enquiry_id' => $enquiry->id,
                    'sender_id' => $customer->id
                ]);
        }
    }
}
