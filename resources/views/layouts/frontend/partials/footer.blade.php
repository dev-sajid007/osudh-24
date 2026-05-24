
 <footer class="bg-gray-800 text-white py-12">
     <div class="container mx-auto px-4">
         <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
             <!-- Company Info -->
             <div>
                 <div class="flex items-center mb-4">
                     @if (isset($settings['site_logo']) && $settings['site_logo'])
                         <img src="{{ $settings['site_logo'] }}"
                             alt="{{ $settings['footer_company_name'] ?? 'Osudh24' }}" class="h-8 w-auto mr-3">
                     @else
                         <div class="bg-cyan-600 text-white p-2 rounded-lg mr-3">
                             <i data-lucide="cross" class="w-6 h-6"></i>
                         </div>
                     @endif
                     <div>
                         <h3 class="text-xl font-bold">{{ $settings['footer_company_name'] ?? 'Osudh24' }}</h3>
                     </div>
                 </div>
                 <p class="text-gray-400 mb-4">
                     {{ $settings['footer_description'] ?? 'Your trusted online pharmacy delivering health and wellness to your doorstep.' }}
                 </p>
                 <div class="flex space-x-4">
                     <a href="{{ $settings['facebook_url'] ?? '#' }}" class="hover:text-cyan-400"><i
                             data-lucide="facebook" class="w-5 h-5 cursor-pointer"></i></a>
                     <a href="{{ $settings['twitter_url'] ?? '#' }}" class="hover:text-cyan-400"><i
                             data-lucide="twitter" class="w-5 h-5 cursor-pointer"></i></a>
                     <a href="{{ $settings['instagram_url'] ?? '#' }}" class="hover:text-cyan-400"><i
                             data-lucide="instagram" class="w-5 h-5 cursor-pointer"></i></a>
                     <a href="{{ $settings['linkedin_url'] ?? '#' }}" class="hover:text-cyan-400"><i
                             data-lucide="linkedin" class="w-5 h-5 cursor-pointer"></i></a>
                 </div>
             </div>

             <!-- Quick Links -->
             <div>
                 <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                 <ul class="space-y-2 text-gray-400">
                     <li><a href="#" class="hover:text-white">About Us</a></li>
                     <li><a href="{{ route('health-services.index') }}" class="hover:text-white">Our Services</a></li>
                     <li><a href="#" class="hover:text-white">Health Blog</a></li>
                     <li><a href="{{ route('contact.index') }}" class="hover:text-white">Contact Us</a></li>
                     <li><a href="#" class="hover:text-white">Store Locator</a></li>
                 </ul>
             </div>

             <!-- Categories -->
             <div>
                 <h4 class="text-lg font-semibold mb-4">Categories</h4>
                 <ul class="space-y-2 text-gray-400">
                     <li><a href="{{ route('categories.index') }}" class="hover:text-white">All Categories</a></li>
                     <li><a href="{{ route('generics.index') }}" class="hover:text-white">Browse Generics</a></li>
                     <li><a href="{{ route('generics.compare') }}" class="hover:text-white">Compare Medicines</a></li>
                     <li><a href="#" class="hover:text-white">Health & Wellness</a></li>
                     <li><a href="#" class="hover:text-white">Medical Devices</a></li>
                 </ul>
             </div>

             <!-- Contact Info -->
             <div>
                 <h4 class="text-lg font-semibold mb-4">Contact Info</h4>
                 <div class="space-y-3 text-gray-400">
                     <div class="flex items-center">
                         <i data-lucide="map-pin" class="w-5 h-5 mr-3"></i>
                         <span>{{ $settings['footer_address'] ?? '123 Health Street, Medical City, MC 12345' }}</span>
                     </div>
                     <div class="flex items-center">
                         <i data-lucide="phone" class="w-5 h-5 mr-3"></i>
                         <span>{{ $settings['footer_phone'] ?? '+1 (555) 123-4567' }}</span>
                     </div>
                     <div class="flex items-center">
                         <i data-lucide="mail" class="w-5 h-5 mr-3"></i>
                         <span>{{ $settings['footer_email'] ?? 'info@pharmacare.com' }}</span>
                     </div>
                     <div class="flex items-center">
                         <i data-lucide="clock" class="w-5 h-5 mr-3"></i>
                         <span>{{ $settings['footer_support_hours'] ?? '24/7 Customer Support' }}</span>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Bottom Bar -->
         <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
             <p class="text-gray-400 text-sm">
                 {{ $settings['copyright_text'] ?? '© 2024 PharmaCare. All rights reserved.' }}</p>
             <div class="flex space-x-6 mt-4 md:mt-0">
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Privacy Policy</a>
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Terms of Service</a>
                 <a href="#" class="text-gray-400 hover:text-white text-sm">Cookie Policy</a>
             </div>
         </div>
     </div>
 </footer>
