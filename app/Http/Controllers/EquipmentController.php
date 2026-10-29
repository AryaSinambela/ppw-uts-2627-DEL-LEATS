<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Equipment;
use App\Models\Category;

abstract class Controller
{
    //
}

class EquipmentController extends Controller
{
    public function index(Request $request)
    {
        $EquipmentQuery = Equipment::query();
        
        $query = $request->get('search');
        if ($query) {
            $EquipmentQuery->where(function($q) use ($query) {
                $q->where('nama', 'like', '%' . $query . '%')
                  ->orWhere('Category_id', 'like', '%' . $query . '%');
            });
        }

        $Equipments = $EquipmentQuery->get()->toArray();

        return view('home', ['Equipments' => $Equipments, 'query' => $query]);
    }

    public function borrow()
    {
        $LoanRequestRequest = LoanRequest::all();
        return view('borrow', ['LoanRequestRequest' => $LoanRequestRequest]);
    }

    public function storeLoanRequest(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string', 
            'judul' => 'required|string'
        ]);

        // Check if Equipment exists and is available
        $Equipment = Equipment::where('judul', $request->judul)->first();
        if (!$Equipment) {
            return response()->json(['error' => 'Buku tidak ditemukan'], 404);
        }
        
        if ($Equipment->status === 'Dipinjam') {
            return response()->json(['error' => 'Buku sudah dipinjam'], 400);
        }

        // Create LoanRequest record with Equipment_id
        LoanRequest::create([
            'Equipment_id' => $Equipment->id,
            'nama' => $request->nama,
            'nim' => $request->nim,
            'judul' => $request->judul
        ]);

        // Update Equipment status to 'Dipinjam'
        $Equipment->update(['status' => 'Dipinjam']);

        return response()->json(['success' => true, 'message' => 'Buku berhasil dipinjam']);
    }

    public function returnEquipment(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $LoanRequest = LoanRequest::with('Equipment')->find($request->id);
        if (!$LoanRequest) {
            return response()->json(['error' => 'Peminjaman tidak ditemukan'], 404);
        }

        // Update Equipment status back to 'Tersedia'
        if ($LoanRequest->Equipment) {
            $LoanRequest->Equipment->update(['status' => 'Tersedia']);
        }

        // Delete LoanRequest record
        $LoanRequest->delete();

        return response()->json(['success' => true, 'message' => 'Buku berhasil dikembalikan']);
    }

    public function clearLoanRequestRequest(Request $request)
    {
        // Get all LoanRequestRequest with Equipments
        $LoanRequestRequest = LoanRequest::with('Equipment')->get();
        
        // Update all borrowed Equipments to 'Tersedia'
        foreach ($LoanRequestRequest as $LoanRequest) {
            if ($LoanRequest->Equipment) {
                $LoanRequest->Equipment->update(['status' => 'Tersedia']);
            }
        }

        // Delete all LoanRequestRequest
        LoanRequest::truncate();

        return response()->json(['success' => true, 'message' => 'Semua peminjaman berhasil dihapus']);
    }
}