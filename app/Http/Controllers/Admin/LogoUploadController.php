<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoUploadController extends Controller
{
    /**
     * Show the logo upload page
     */
    public function index(Request $request)
    {
        $universityQuery = University::query();
        $bankQuery = Bank::where('is_active', true);
        
        // Search filter
        if ($request->has('search_university') && $request->search_university) {
            $universityQuery->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_university . '%')
                  ->orWhere('acronym', 'like', '%' . $request->search_university . '%')
                  ->orWhere('city', 'like', '%' . $request->search_university . '%');
            });
        }
        
        if ($request->has('search_bank') && $request->search_bank) {
            $bankQuery->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_bank . '%')
                  ->orWhere('code', 'like', '%' . $request->search_bank . '%');
            });
        }
        
        // Sort: yang punya logo_url di atas, kemudian urutkan berdasarkan nama
        $universities = $universityQuery->orderByRaw('CASE WHEN logo_url IS NULL OR logo_url = "" THEN 1 ELSE 0 END')
                                       ->orderBy('name')
                                       ->get();
        $banks = $bankQuery->orderByRaw('CASE WHEN logo_url IS NULL OR logo_url = "" THEN 1 ELSE 0 END')
                          ->orderBy('name')
                          ->get();
        
        return view('admin.logo-upload', compact('universities', 'banks'));
    }

    /**
     * Store new university
     */
    public function storeUniversity(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:universities,name',
                'acronym' => 'nullable|string|max:50',
                'type' => 'required|in:negeri,swasta',
                'city' => 'nullable|string|max:100',
                'province' => 'nullable|string|max:100',
                'website' => 'nullable|url|max:255',
            ]);

            $university = University::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Universitas berhasil ditambahkan',
                'university' => $university
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store new bank
     */
    public function storeBank(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:banks,name',
                'code' => 'nullable|string|max:20',
                'swift_code' => 'nullable|string|max:20',
                'is_active' => 'nullable|boolean',
            ]);

            $validated['is_active'] = $request->has('is_active') ? true : false;

            $bank = Bank::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Bank berhasil ditambahkan',
                'bank' => $bank
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload university logo
     */
    public function uploadUniversity(Request $request, University $university)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Delete old logo if exists
        if ($university->logo_url && str_starts_with($university->logo_url, 'logos/')) {
            Storage::disk('public')->delete($university->logo_url);
        }

        // Upload new logo
        $logo = $request->file('logo');
        $filename = 'university_' . $university->id . '_' . time() . '.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('logos/universities', $filename, 'public');

        // Update database
        $university->update([
            'logo_url' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil diupload',
            'logo_url' => Storage::url($path)
        ]);
    }

    /**
     * Upload bank logo
     */
    public function uploadBank(Request $request, Bank $bank)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Delete old logo if exists
        if ($bank->logo_url && str_starts_with($bank->logo_url, 'logos/')) {
            Storage::disk('public')->delete($bank->logo_url);
        }

        // Upload new logo
        $logo = $request->file('logo');
        $filename = 'bank_' . $bank->id . '_' . time() . '.' . $logo->getClientOriginalExtension();
        $path = $logo->storeAs('logos/banks', $filename, 'public');

        // Update database with relative path
        $bank->update([
            'logo_url' => $path
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil diupload',
            'logo_url' => Storage::url($path)
        ]);
    }

    /**
     * Delete university logo
     */
    public function deleteUniversity(University $university)
    {
        if ($university->logo_url && str_starts_with($university->logo_url, 'logos/')) {
            Storage::disk('public')->delete($university->logo_url);
        }

        $university->update(['logo_url' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil dihapus'
        ]);
    }

    /**
     * Delete bank logo
     */
    public function deleteBank(Bank $bank)
    {
        if ($bank->logo_url && str_starts_with($bank->logo_url, 'logos/')) {
            Storage::disk('public')->delete($bank->logo_url);
        }

        $bank->update(['logo_url' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Logo berhasil dihapus'
        ]);
    }
}
