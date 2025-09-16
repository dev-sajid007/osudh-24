<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $group = $request->get('group', 'all');

        $query = WebsiteSetting::ordered();

        if ($group !== 'all') {
            $query->byGroup($group);
        }

        $settings = $query->paginate(20);

        $groups = WebsiteSetting::select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        return view('admin.website-settings.index', compact('settings', 'groups', 'group'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $groups = ['general', 'header', 'footer', 'contact', 'social'];
        $types = ['text', 'textarea', 'email', 'phone', 'url', 'number', 'image'];

        return view('admin.website-settings.create', compact('groups', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|unique:website_settings,key|max:255',
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,email,phone,url,number,image',
            'group' => 'required|string|max:255',
            'value' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        WebsiteSetting::create($request->all());

        return redirect()->route('admin.website-settings.index')
            ->with('success', 'Website setting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteSetting $websiteSetting)
    {
        return view('admin.website-settings.show', compact('websiteSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteSetting $websiteSetting)
    {
        $groups = ['general', 'header', 'footer', 'contact', 'social'];
        $types = ['text', 'textarea', 'email', 'phone', 'url', 'number', 'image'];

        return view('admin.website-settings.edit', compact('websiteSetting', 'groups', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteSetting $websiteSetting)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:website_settings,key,' . $websiteSetting->id,
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,email,phone,url,number,image',
            'group' => 'required|string|max:255',
            'value' => 'nullable|string',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean'
        ]);

        $websiteSetting->update($request->all());

        return redirect()->route('admin.website-settings.index')
            ->with('success', 'Website setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteSetting $websiteSetting)
    {
        $websiteSetting->delete();

        return redirect()->route('admin.website-settings.index')
            ->with('success', 'Website setting deleted successfully.');
    }

    /**
     * Bulk update settings (for quick editing)
     */
    public function bulkUpdate(Request $request)
    {
        $settings = $request->get('settings', []);

        foreach ($settings as $id => $value) {
            $setting = WebsiteSetting::find($id);
            if ($setting) {
                $setting->update(['value' => $value]);
            }
        }

        // Clear all cache
        Cache::flush();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
