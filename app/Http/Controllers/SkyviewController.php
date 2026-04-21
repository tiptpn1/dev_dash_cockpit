<?php

namespace App\Http\Controllers;

use App\Models\Skyview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkyviewController extends Controller
{
    /**
     * Display a listing of all skyview data.
     */
    public function index(Request $request)
    {
        $q          = $request->input('q', '');
        $tglAwal    = $request->input('tgl_awal', '');
        $tglAkhir   = $request->input('tgl_akhir', '');
        $perPage    = 10;

        $query = Skyview::query()->orderByDesc('tanggal');

        if ($q) {
            $query->where('kebun_unit', 'like', '%' . $q . '%');
        }
        if ($tglAwal) {
            $query->whereDate('tanggal', '>=', $tglAwal);
        }
        if ($tglAkhir) {
            $query->whereDate('tanggal', '<=', $tglAkhir);
        }

        $skyviews = $query->paginate($perPage)->withQueryString();

        return view('pages.skyview_table', compact('skyviews', 'q', 'tglAwal', 'tglAkhir'));
    }

    /**
     * Store a newly created skyview in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kebun_unit'   => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'link_youtube' => 'required|url|max:500',
        ], [
            'kebun_unit.required'   => 'Kebun/Unit wajib diisi.',
            'tanggal.required'      => 'Tanggal wajib diisi.',
            'link_youtube.required' => 'Link YouTube wajib diisi.',
            'link_youtube.url'      => 'Format link YouTube tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $skyview = Skyview::create($request->only('kebun_unit', 'tanggal', 'link_youtube', 'keterangan'));

        return response()->json([
            'success' => true,
            'message' => 'Data Skyview berhasil ditambahkan.',
            'data'    => $skyview,
        ]);
    }

    /**
     * Return a single skyview as JSON (for edit form).
     */
    public function show(Skyview $skyview)
    {
        return response()->json([
            'success' => true,
            'data'    => $skyview,
        ]);
    }

    /**
     * Update the specified skyview in storage.
     */
    public function update(Request $request, Skyview $skyview)
    {
        $validator = Validator::make($request->all(), [
            'kebun_unit'   => 'required|string|max:255',
            'tanggal'      => 'required|date',
            'link_youtube' => 'required|url|max:500',
        ], [
            'kebun_unit.required'   => 'Kebun/Unit wajib diisi.',
            'tanggal.required'      => 'Tanggal wajib diisi.',
            'link_youtube.required' => 'Link YouTube wajib diisi.',
            'link_youtube.url'      => 'Format link YouTube tidak valid.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        $skyview->update($request->only('kebun_unit', 'tanggal', 'link_youtube', 'keterangan'));

        return response()->json([
            'success' => true,
            'message' => 'Data Skyview berhasil diperbarui.',
            'data'    => $skyview,
        ]);
    }

    /**
     * Remove the specified skyview from storage.
     */
    public function destroy(Skyview $skyview)
    {
        $skyview->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data Skyview berhasil dihapus.',
        ]);
    }
}
