<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebsiteSettingController extends Controller
{
    /**
     * Display listing
     */
    public function index(Request $request)
    {
        $group = $request->get('group', 'all');

        // Query Start
        $query = WebsiteSetting::query()->orderBy('sort_order')->orderBy('id');

        // Filter by group
        if ($group !== 'all') {
            $query->where('group', $group);
        }

        // Pagination
        $settings = $query->paginate(20);

        // All groups
        $groups = WebsiteSetting::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        return view('admin.website-settings.index', compact(
            'settings',
            'groups',
            'group'
        ));
    }

    /**
     * Create form
     */
    public function create()
    {
        $groups = ['general', 'header', 'footer', 'contact', 'social'];

        $types = [
            'text',
            'textarea',
            'email',
            'phone',
            'url',
            'number',
            'image'
        ];

        return view('admin.website-settings.create', compact('groups', 'types'));
    }

    /**
     * Store data
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:website_settings,key',
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,email,phone,url,number,image',
            'group' => 'required|string|max:255',
            'value' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        WebsiteSetting::create($validated);

        Cache::flush();

        return redirect()
            ->route('admin.website-settings.index')
            ->with('success', 'Website setting created successfully.');
    }

    /**
     * Show single item
     */
    public function show(WebsiteSetting $websiteSetting)
    {
        return view('admin.website-settings.show', compact('websiteSetting'));
    }

    /**
     * Edit form
     */
    public function edit(WebsiteSetting $websiteSetting)
    {
        $groups = ['general', 'header', 'footer', 'contact', 'social'];

        $types = [
            'text',
            'textarea',
            'email',
            'phone',
            'url',
            'number',
            'image'
        ];

        return view('admin.website-settings.edit', compact(
            'websiteSetting',
            'groups',
            'types'
        ));
    }

    /**
     * Update data
     */
    public function update(Request $request, WebsiteSetting $websiteSetting)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:website_settings,key,' . $websiteSetting->id,
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,email,phone,url,number,image',
            'group' => 'required|string|max:255',
            'value' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $websiteSetting->update($validated);

        Cache::flush();

        return redirect()
            ->route('admin.website-settings.index')
            ->with('success', 'Website setting updated successfully.');
    }

    /**
     * Delete item
     */
    public function destroy(WebsiteSetting $websiteSetting)
    {
        $websiteSetting->delete();

        Cache::flush();

        return redirect()
            ->route('admin.website-settings.index')
            ->with('success', 'Website setting deleted successfully.');
    }

    /**
     * Bulk update
     */
    public function bulkUpdate(Request $request)
    {
        $settings = $request->get('settings', []);

        foreach ($settings as $id => $value) {

            $setting = WebsiteSetting::find($id);

            if ($setting) {
                $setting->update([
                    'value' => $value
                ]);
            }
        }

        Cache::flush();

        return redirect()
            ->back()
            ->with('success', 'Settings updated successfully.');
    }
}