<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Score;
use App\Models\Service;

class SurveiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $currentYear = now()->year;
        $statistik = Score::whereYear('created_at', $currentYear)
            ->select(
                DB::raw('SUM(perpustakaan) as perpustakaan'),
                DB::raw('SUM(konsultasi) as konsultasi'),
                DB::raw('SUM(penjualan) as penjualan'),
                DB::raw('SUM(rekomendasi) as rekomendasi'),
                DB::raw('SUM(umum) as umum'),
                DB::raw('SUM(pengaduan) as pengaduan')
        )->first();
        return Inertia::render('Survei/Index',[
            'statistik' => $statistik
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $serviceIds = $request->checkedLayanans;
        $services = Service::whereIn('kode', $serviceIds)->pluck('nama')->toArray();

        $score = new Score();

        foreach ($services as $service) {
            $score->$service = 1;
        }        
        $score->nilai = $request->nilai;
        $score->save();

        return redirect()->route('survei.index')->with('message', $score->nilai);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
