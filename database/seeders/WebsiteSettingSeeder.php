<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WebsiteSetting;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Header Settings
            [
                'key' => 'site_name',
                'value' => 'Osudh24',
                'type' => 'text',
                'group' => 'header',
                'label' => 'Site Name',
                'description' => 'The main name of the website',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'key' => 'site_tagline',
                'value' => 'Your Health, Our Priority',
                'type' => 'text',
                'group' => 'header',
                'label' => 'Site Tagline',
                'description' => 'The tagline that appears under the site name',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'key' => 'header_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'phone',
                'group' => 'header',
                'label' => 'Header Phone Number',
                'description' => 'Phone number displayed in the header',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'key' => 'header_email',
                'value' => 'info@osudh24.com',
                'type' => 'email',
                'group' => 'header',
                'label' => 'Header Email',
                'description' => 'Email address displayed in the header',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'key' => 'free_shipping_message',
                'value' => 'Free shipping on orders over $50',
                'type' => 'text',
                'group' => 'header',
                'label' => 'Free Shipping Message',
                'description' => 'Message about free shipping displayed in header',
                'sort_order' => 5,
                'is_active' => true
            ],

            // Footer Settings
            [
                'key' => 'footer_company_name',
                'value' => 'PharmaCare',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Footer Company Name',
                'description' => 'Company name displayed in footer',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'key' => 'footer_description',
                'value' => 'Your trusted online pharmacy delivering health and wellness to your doorstep.',
                'type' => 'textarea',
                'group' => 'footer',
                'label' => 'Footer Description',
                'description' => 'Company description in footer',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'key' => 'footer_address',
                'value' => '123 Health Street, Medical City, MC 12345',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Footer Address',
                'description' => 'Company address displayed in footer',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'key' => 'footer_phone',
                'value' => '+1 (555) 123-4567',
                'type' => 'phone',
                'group' => 'footer',
                'label' => 'Footer Phone',
                'description' => 'Phone number displayed in footer',
                'sort_order' => 4,
                'is_active' => true
            ],
            [
                'key' => 'footer_email',
                'value' => 'info@pharmacare.com',
                'type' => 'email',
                'group' => 'footer',
                'label' => 'Footer Email',
                'description' => 'Email address displayed in footer',
                'sort_order' => 5,
                'is_active' => true
            ],
            [
                'key' => 'footer_support_hours',
                'value' => '24/7 Customer Support',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Support Hours',
                'description' => 'Customer support hours information',
                'sort_order' => 6,
                'is_active' => true
            ],
            [
                'key' => 'copyright_text',
                'value' => '© 2024 PharmaCare. All rights reserved.',
                'type' => 'text',
                'group' => 'footer',
                'label' => 'Copyright Text',
                'description' => 'Copyright notice in footer',
                'sort_order' => 7,
                'is_active' => true
            ],

            // Social Media Settings
            [
                'key' => 'facebook_url',
                'value' => '#',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Facebook URL',
                'description' => 'Link to Facebook page',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'key' => 'twitter_url',
                'value' => '#',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Twitter URL',
                'description' => 'Link to Twitter profile',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'key' => 'instagram_url',
                'value' => '#',
                'type' => 'url',
                'group' => 'social',
                'label' => 'Instagram URL',
                'description' => 'Link to Instagram profile',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'key' => 'linkedin_url',
                'value' => '#',
                'type' => 'url',
                'group' => 'social',
                'label' => 'LinkedIn URL',
                'description' => 'Link to LinkedIn profile',
                'sort_order' => 4,
                'is_active' => true
            ],

            // General Settings
            [
                'key' => 'site_logo',
                'value' => '',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Site Logo',
                'description' => 'Main site logo image',
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'key' => 'favicon',
                'value' => '',
                'type' => 'image',
                'group' => 'general',
                'label' => 'Favicon',
                'description' => 'Site favicon',
                'sort_order' => 2,
                'is_active' => true
            ],
            [
                'key' => 'meta_description',
                'value' => 'Your trusted online pharmacy for all your healthcare needs',
                'type' => 'textarea',
                'group' => 'general',
                'label' => 'Meta Description',
                'description' => 'Site meta description for SEO',
                'sort_order' => 3,
                'is_active' => true
            ],
            [
                'key' => 'meta_keywords',
                'value' => 'pharmacy, medicine, healthcare, online pharmacy, prescription',
                'type' => 'text',
                'group' => 'general',
                'label' => 'Meta Keywords',
                'description' => 'Site meta keywords for SEO',
                'sort_order' => 4,
                'is_active' => true
            ]
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::create($setting);
        }

        $this->command->info('Website settings seeded successfully!');
    }
}
