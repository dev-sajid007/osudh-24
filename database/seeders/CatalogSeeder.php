<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Generic;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Categories
        $categories = [
            [
                'name' => 'Healthcare',
                'slug' => 'healthcare',
                'description' => 'General healthcare products and medications',
                'is_active' => true,
                'sort_order' => 1,
                'children' => [
                    ['name' => 'Pain Relief', 'slug' => 'pain-relief'],
                    ['name' => 'Cold & Flu', 'slug' => 'cold-flu'],
                    ['name' => 'Digestive Health', 'slug' => 'digestive-health'],
                    ['name' => 'First Aid', 'slug' => 'first-aid'],
                ]
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty and cosmetic products',
                'is_active' => true,
                'sort_order' => 2,
                'children' => [
                    ['name' => 'Skincare', 'slug' => 'skincare'],
                    ['name' => 'Hair Care', 'slug' => 'hair-care'],
                    ['name' => 'Makeup', 'slug' => 'makeup'],
                    ['name' => 'Fragrances', 'slug' => 'fragrances'],
                ]
            ],
            [
                'name' => 'Sexual Wellness',
                'slug' => 'sexual-wellness',
                'description' => 'Sexual health and wellness products',
                'is_active' => true,
                'sort_order' => 3,
                'children' => [
                    ['name' => 'Contraceptives', 'slug' => 'contraceptives'],
                    ['name' => 'Lubricants', 'slug' => 'lubricants'],
                    ['name' => 'Enhancement Products', 'slug' => 'enhancement-products'],
                ]
            ],
            [
                'name' => 'Baby & Mom Care',
                'slug' => 'baby-mom-care',
                'description' => 'Products for babies and mothers',
                'is_active' => true,
                'sort_order' => 4,
                'children' => [
                    ['name' => 'Baby Food', 'slug' => 'baby-food'],
                    ['name' => 'Diapers', 'slug' => 'diapers'],
                    ['name' => 'Baby Skincare', 'slug' => 'baby-skincare'],
                    ['name' => 'Maternity Care', 'slug' => 'maternity-care'],
                ]
            ],
            [
                'name' => 'Herbal',
                'slug' => 'herbal',
                'description' => 'Natural and herbal products',
                'is_active' => true,
                'sort_order' => 5,
                'children' => [
                    ['name' => 'Herbal Supplements', 'slug' => 'herbal-supplements'],
                    ['name' => 'Ayurvedic Medicines', 'slug' => 'ayurvedic-medicines'],
                    ['name' => 'Herbal Teas', 'slug' => 'herbal-teas'],
                    ['name' => 'Essential Oils', 'slug' => 'essential-oils'],
                ]
            ],
            [
                'name' => 'Home Care',
                'slug' => 'home-care',
                'description' => 'Home cleaning and care products',
                'is_active' => true,
                'sort_order' => 6,
                'children' => [
                    ['name' => 'Disinfectants', 'slug' => 'disinfectants'],
                    ['name' => 'Hand Sanitizers', 'slug' => 'hand-sanitizers'],
                    ['name' => 'Surface Cleaners', 'slug' => 'surface-cleaners'],
                    ['name' => 'Air Fresheners', 'slug' => 'air-fresheners'],
                ]
            ],
            [
                'name' => 'Supplement',
                'slug' => 'supplement',
                'description' => 'Nutritional supplements and vitamins',
                'is_active' => true,
                'sort_order' => 7,
                'children' => [
                    ['name' => 'Multivitamins', 'slug' => 'multivitamins'],
                    ['name' => 'Protein Supplements', 'slug' => 'protein-supplements'],
                    ['name' => 'Omega-3', 'slug' => 'omega-3'],
                    ['name' => 'Probiotics', 'slug' => 'probiotics'],
                ]
            ],
            [
                'name' => 'Food and Nutrition',
                'slug' => 'food-nutrition',
                'description' => 'Nutritional foods and dietary products',
                'is_active' => true,
                'sort_order' => 8,
                'children' => [
                    ['name' => 'Health Drinks', 'slug' => 'health-drinks'],
                    ['name' => 'Diabetic Foods', 'slug' => 'diabetic-foods'],
                    ['name' => 'Protein Bars', 'slug' => 'protein-bars'],
                    ['name' => 'Organic Foods', 'slug' => 'organic-foods'],
                ]
            ],
            [
                'name' => 'Pet Care',
                'slug' => 'pet-care',
                'description' => 'Pet health and care products',
                'is_active' => true,
                'sort_order' => 9,
                'children' => [
                    ['name' => 'Pet Food', 'slug' => 'pet-food'],
                    ['name' => 'Pet Grooming', 'slug' => 'pet-grooming'],
                    ['name' => 'Pet Accessories', 'slug' => 'pet-accessories'],
                    ['name' => 'Pet Toys', 'slug' => 'pet-toys'],
                ]
            ],
            [
                'name' => 'Veterinary',
                'slug' => 'veterinary',
                'description' => 'Veterinary medicines and treatments',
                'is_active' => true,
                'sort_order' => 10,
                'children' => [
                    ['name' => 'Pet Medications', 'slug' => 'pet-medications'],
                    ['name' => 'Vaccines', 'slug' => 'vaccines'],
                    ['name' => 'Dewormers', 'slug' => 'dewormers'],
                    ['name' => 'Flea & Tick Control', 'slug' => 'flea-tick-control'],
                ]
            ],
            [
                'name' => 'Homeopathy',
                'slug' => 'homeopathy',
                'description' => 'Homeopathic medicines and remedies',
                'is_active' => true,
                'sort_order' => 11,
                'children' => [
                    ['name' => 'Acute Remedies', 'slug' => 'acute-remedies'],
                    ['name' => 'Constitutional Remedies', 'slug' => 'constitutional-remedies'],
                    ['name' => 'Tissue Salts', 'slug' => 'tissue-salts'],
                    ['name' => 'Mother Tinctures', 'slug' => 'mother-tinctures'],
                ]
            ]
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $category = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $category->id;
                $childData['is_active'] = true;
                $childData['sort_order'] = 0;
                Category::create($childData);
            }
        }

        // Create Suppliers
        $suppliers = [
            [
                'name' => 'PharmaCorp Ltd',
                'code' => 'PC001',
                'contact_person' => 'John Smith',
                'email' => 'john@pharmacorp.com',
                'phone' => '+91-9876543210',
                'address' => '123 Medical District',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'postal_code' => '400001',
                'gst_number' => '27AAACP1234C1ZS',
                'license_number' => 'DL-20-21/01234',
                'is_active' => true
            ],
            [
                'name' => 'MediSupply Co',
                'code' => 'MS002',
                'contact_person' => 'Sarah Johnson',
                'email' => 'sarah@medisupply.com',
                'phone' => '+91-9876543211',
                'address' => '456 Healthcare Plaza',
                'city' => 'Delhi',
                'state' => 'Delhi',
                'postal_code' => '110001',
                'gst_number' => '07AAACP1234C1ZS',
                'license_number' => 'DL-07-21/01235',
                'is_active' => true
            ],
            [
                'name' => 'Global Pharmaceuticals',
                'code' => 'GP003',
                'contact_person' => 'Dr. Rajesh Kumar',
                'email' => 'rajesh@globalpharma.com',
                'phone' => '+91-9876543212',
                'address' => '789 Pharma Complex',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'postal_code' => '560001',
                'gst_number' => '29AAACP1234C1ZS',
                'license_number' => 'DL-29-21/01236',
                'is_active' => true
            ]
        ];

        foreach ($suppliers as $supplierData) {
            Supplier::create($supplierData);
        }

        // Create Generics
        $generics = [
            [
                'name' => 'Paracetamol',
                'slug' => 'paracetamol',
                'description' => 'Analgesic and antipyretic medication used to treat pain and fever.',
                'is_active' => true
            ],
            [
                'name' => 'Ibuprofen',
                'slug' => 'ibuprofen',
                'description' => 'Nonsteroidal anti-inflammatory drug (NSAID) used for pain relief and inflammation.',
                'is_active' => true
            ],
            [
                'name' => 'Aspirin',
                'slug' => 'aspirin',
                'description' => 'Pain reliever and anti-inflammatory medication, also used for cardiovascular protection.',
                'is_active' => true
            ],
            [
                'name' => 'Dextromethorphan',
                'slug' => 'dextromethorphan',
                'description' => 'Cough suppressant used in many over-the-counter cold and cough medicines.',
                'is_active' => true
            ],
            [
                'name' => 'Diphenhydramine',
                'slug' => 'diphenhydramine',
                'description' => 'Antihistamine used to treat allergies, insomnia, and cold symptoms.',
                'is_active' => true
            ],
            [
                'name' => 'Omeprazole',
                'slug' => 'omeprazole',
                'description' => 'Proton pump inhibitor used to treat acid reflux and stomach ulcers.',
                'is_active' => true
            ],
            [
                'name' => 'Loperamide',
                'slug' => 'loperamide',
                'description' => 'Anti-diarrheal medication used to treat diarrhea.',
                'is_active' => true
            ],
            [
                'name' => 'Multivitamin',
                'slug' => 'multivitamin',
                'description' => 'Combination of vitamins and minerals for general health support.',
                'is_active' => true
            ],
            [
                'name' => 'Vitamin D3',
                'slug' => 'vitamin-d3',
                'description' => 'Essential vitamin for bone health and immune function.',
                'is_active' => true
            ],
            [
                'name' => 'Calcium Carbonate',
                'slug' => 'calcium-carbonate',
                'description' => 'Calcium supplement for bone health and as an antacid.',
                'is_active' => true
            ],
            [
                'name' => 'Amoxicillin',
                'slug' => 'amoxicillin',
                'description' => 'Penicillin-type antibiotic used to treat bacterial infections.',
                'is_active' => true
            ],
            [
                'name' => 'Azithromycin',
                'slug' => 'azithromycin',
                'description' => 'Macrolide antibiotic used to treat various bacterial infections.',
                'is_active' => true
            ],
            [
                'name' => 'Lisinopril',
                'slug' => 'lisinopril',
                'description' => 'ACE inhibitor used to treat high blood pressure and heart failure.',
                'is_active' => true
            ],
            [
                'name' => 'Metformin',
                'slug' => 'metformin',
                'description' => 'Medication for type 2 diabetes that helps control blood sugar levels.',
                'is_active' => true
            ],
            [
                'name' => 'Sodium Bicarbonate',
                'slug' => 'sodium-bicarbonate',
                'description' => 'Antacid used to treat heartburn and indigestion.',
                'is_active' => true
            ]
        ];

        foreach ($generics as $genericData) {
            Generic::create($genericData);
        }

        // Create Products
        $healthcareCategory = Category::where('slug', 'healthcare')->first();
        $painReliefCategory = Category::where('slug', 'pain-relief')->first();
        $coldFluCategory = Category::where('slug', 'cold-flu')->first();
        $digestiveCategory = Category::where('slug', 'digestive-health')->first();
        $beautyCategory = Category::where('slug', 'beauty')->first();
        $skincareCategory = Category::where('slug', 'skincare')->first();
        $supplementCategory = Category::where('slug', 'supplement')->first();
        $multivitaminCategory = Category::where('slug', 'multivitamins')->first();
        $herbalCategory = Category::where('slug', 'herbal')->first();
        $homeopathyCategory = Category::where('slug', 'homeopathy')->first();

        $supplier1 = Supplier::where('code', 'PC001')->first();
        $supplier2 = Supplier::where('code', 'MS002')->first();
        $supplier3 = Supplier::where('code', 'GP003')->first();

        // Get Generic references
        $paracetamolGeneric = Generic::where('slug', 'paracetamol')->first();
        $ibuprofenGeneric = Generic::where('slug', 'ibuprofen')->first();
        $aspirinGeneric = Generic::where('slug', 'aspirin')->first();
        $dextromethorphanGeneric = Generic::where('slug', 'dextromethorphan')->first();
        $diphenhydramineGeneric = Generic::where('slug', 'diphenhydramine')->first();
        $omeprazoleGeneric = Generic::where('slug', 'omeprazole')->first();
        $loperamideGeneric = Generic::where('slug', 'loperamide')->first();
        $multivitaminGeneric = Generic::where('slug', 'multivitamin')->first();
        $vitaminD3Generic = Generic::where('slug', 'vitamin-d3')->first();
        $calciumGeneric = Generic::where('slug', 'calcium-carbonate')->first();
        $amoxicillinGeneric = Generic::where('slug', 'amoxicillin')->first();
        $azithromycinGeneric = Generic::where('slug', 'azithromycin')->first();
        $lisinoprilGeneric = Generic::where('slug', 'lisinopril')->first();
        $metforminGeneric = Generic::where('slug', 'metformin')->first();
        $sodiumBicarbonateGeneric = Generic::where('slug', 'sodium-bicarbonate')->first();

        $products = [
            // Pain Relief Products
            [
                'name' => 'Paracetamol 500mg Tablets',
                'brand' => 'Crocin',
                'generic_id' => $paracetamolGeneric->id,
                'sku' => 'PARA500-10',
                'barcode' => '8901030890127',
                'dosage' => '500mg',
                'form' => 'tablet',
                'strength' => '500mg',
                'package_size' => '10 tablets',
                'prescription_required' => false,
                'category_id' => $painReliefCategory->id,
                'description' => 'Effective pain relief and fever reducer. Safe for adults and children over 12 years.',
                'unit_price' => 25.00,
                'mrp' => 30.00,
                'discount' => 16.67,
                'tax_rate' => 12.00,
                'supplier_id' => $supplier1->id,
                'stock_quantity' => 500,
                'minimum_stock' => 50,
                'maximum_stock' => 1000,
                'expiry_date' => '2026-12-31',
                'storage_instructions' => 'Store in a cool, dry place below 30°C',
                'side_effects' => 'Rare: skin rash, nausea. Overdose can cause liver damage.',
                'usage_instructions' => 'Adults: 1-2 tablets every 4-6 hours. Maximum 8 tablets in 24 hours.',
                'tags' => ['pain relief', 'fever', 'headache', 'otc'],
                'status' => 'active'
            ],
            [
                'name' => 'Ibuprofen 400mg Tablets',
                'brand' => 'Brufen',
                'generic_id' => $ibuprofenGeneric->id,
                'sku' => 'IBU400-10',
                'barcode' => '8901030890134',
                'dosage' => '400mg',
                'form' => 'tablet',
                'strength' => '400mg',
                'package_size' => '10 tablets',
                'prescription_required' => false,
                'category_id' => $painReliefCategory->id,
                'description' => 'Anti-inflammatory pain reliever for muscle pain, joint pain, and fever.',
                'unit_price' => 45.00,
                'mrp' => 55.00,
                'discount' => 18.18,
                'tax_rate' => 12.00,
                'supplier_id' => $supplier1->id,
                'stock_quantity' => 300,
                'minimum_stock' => 30,
                'maximum_stock' => 500,
                'expiry_date' => '2026-10-31',
                'storage_instructions' => 'Store below 25°C in original packaging',
                'side_effects' => 'May cause stomach upset. Take with food.',
                'usage_instructions' => 'Adults: 1 tablet 2-3 times daily with food.',
                'tags' => ['pain relief', 'anti-inflammatory', 'fever', 'otc'],
                'status' => 'active'
            ],

            // Cold & Flu Products
            [
                'name' => 'Cough Syrup 100ml',
                'brand' => 'Benadryl',
                'generic_id' => $dextromethorphanGeneric->id,
                'sku' => 'COUGH100-SYR',
                'barcode' => '8901030890141',
                'dosage' => '10ml',
                'form' => 'syrup',
                'strength' => '15mg/5ml + 5mg/5ml',
                'package_size' => '100ml bottle',
                'prescription_required' => false,
                'category_id' => $coldFluCategory->id,
                'description' => 'Relief from dry cough and nasal congestion.',
                'unit_price' => 85.00,
                'mrp' => 95.00,
                'discount' => 10.53,
                'tax_rate' => 12.00,
                'supplier_id' => $supplier2->id,
                'stock_quantity' => 150,
                'minimum_stock' => 20,
                'maximum_stock' => 200,
                'expiry_date' => '2025-12-31',
                'storage_instructions' => 'Store below 30°C. Do not freeze.',
                'side_effects' => 'Drowsiness, dizziness may occur.',
                'usage_instructions' => 'Adults: 10ml every 6-8 hours. Children 6-12 years: 5ml every 6-8 hours.',
                'tags' => ['cough', 'cold', 'congestion', 'syrup'],
                'status' => 'active'
            ],

            // Vitamins & Supplements
            [
                'name' => 'Multivitamin Tablets',
                'brand' => 'Revital',
                'generic_id' => $multivitaminGeneric->id,
                'sku' => 'MULTI-30',
                'barcode' => '8901030890158',
                'dosage' => '1 tablet',
                'form' => 'tablet',
                'strength' => 'Various vitamins & minerals',
                'package_size' => '30 tablets',
                'prescription_required' => false,
                'category_id' => $multivitaminCategory->id,
                'description' => 'Complete multivitamin and mineral supplement for daily health.',
                'unit_price' => 180.00,
                'mrp' => 200.00,
                'discount' => 10.00,
                'tax_rate' => 18.00,
                'supplier_id' => $supplier2->id,
                'stock_quantity' => 100,
                'minimum_stock' => 15,
                'maximum_stock' => 150,
                'expiry_date' => '2027-06-30',
                'storage_instructions' => 'Store in cool, dry place. Keep container tightly closed.',
                'side_effects' => 'Generally well tolerated. May cause mild stomach upset.',
                'usage_instructions' => 'Adults: 1 tablet daily after breakfast.',
                'tags' => ['vitamins', 'minerals', 'supplement', 'daily'],
                'status' => 'active'
            ],

            // Prescription Medicine
            [
                'name' => 'Amoxicillin 500mg Capsules',
                'brand' => 'Amoxil',
                'generic_id' => $amoxicillinGeneric->id,
                'sku' => 'AMOX500-10',
                'barcode' => '8901030890165',
                'dosage' => '500mg',
                'form' => 'capsule',
                'strength' => '500mg',
                'package_size' => '10 capsules',
                'prescription_required' => true,
                'category_id' => $healthcareCategory->id,
                'description' => 'Broad-spectrum antibiotic for bacterial infections.',
                'unit_price' => 120.00,
                'mrp' => 135.00,
                'discount' => 11.11,
                'tax_rate' => 12.00,
                'supplier_id' => $supplier3->id,
                'stock_quantity' => 75,
                'minimum_stock' => 10,
                'maximum_stock' => 100,
                'expiry_date' => '2026-08-31',
                'storage_instructions' => 'Store below 25°C in original packaging. Keep away from moisture.',
                'side_effects' => 'Nausea, diarrhea, allergic reactions possible.',
                'usage_instructions' => 'Take as prescribed by doctor. Complete full course.',
                'tags' => ['antibiotic', 'prescription', 'bacterial infection'],
                'status' => 'active'
            ],

            // Digestive Health
            [
                'name' => 'Antacid Tablets',
                'brand' => 'ENO',
                'generic_id' => $sodiumBicarbonateGeneric->id,
                'sku' => 'ANTACID-20',
                'barcode' => '8901030890172',
                'dosage' => '1 tablet',
                'form' => 'tablet',
                'strength' => '2.3g',
                'package_size' => '20 tablets',
                'prescription_required' => false,
                'category_id' => $digestiveCategory->id,
                'description' => 'Fast relief from acidity and indigestion.',
                'unit_price' => 35.00,
                'mrp' => 40.00,
                'discount' => 12.50,
                'tax_rate' => 18.00,
                'supplier_id' => $supplier1->id,
                'stock_quantity' => 200,
                'minimum_stock' => 25,
                'maximum_stock' => 300,
                'expiry_date' => '2026-11-30',
                'storage_instructions' => 'Store in dry place below 30°C.',
                'side_effects' => 'Generally safe. Avoid if on low sodium diet.',
                'usage_instructions' => 'Dissolve 1 tablet in water. Take when needed for acidity.',
                'tags' => ['antacid', 'acidity', 'indigestion', 'otc'],
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
