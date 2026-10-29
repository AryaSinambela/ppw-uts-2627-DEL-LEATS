<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoanRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $equipments = Equipment::when($search, function ($query, $search) {
            return $query->where('id', 'like', "%{$search}%")
                        ->orWhere('nama', 'like', "%{$search}%")
                        ->orWhere('kategori', 'like', "%{$search}%");
        })->get();

        $borrows = Borrow::with('Equipment')->whereNull('returned_at')->get();

        return view('library.index', compact('Equipment', 'borrows', 'search'));
    }

    public function borrow(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrower_nim' => 'required|string|size:10|regex:/^[0-9]+$/',
            'equipment_id' => 'required|exists:equipments,id'
        ]);

        $equipment = Equipment::findOrFail($request->equipment_id);

        if ($equipment->status === 'borrowed') {
            return back()->withErrors(['equipment_id' => 'equipment sudah dipinjam!']);
        }

        // Check if user already borrowed this equipment
        $existingBorrow = Borrow::where('borrower_nim', $request->borrower_nim)
            ->where('equipment_id', $request->equipment_id)
            ->whereNull('returned_at')
            ->first();

        if ($existingBorrow) {
            return back()->withErrors(['equipment_id' => 'Anda sudah meminjam equipment ini!']);
        }

        // Create borrow record
        Borrow::create([
            'borrower_name' => $request->borrower_name,
            'borrower_nim' => $request->borrower_nim,
            'equipment_id' => $request->equipment_id,
            'borrowed_at' => Carbon::now(),
        ]);

        // Update equipment status
        $equipment->update(['status' => 'borrowed']);

        return back()->with('success', "equipment \"{$equipment->title}\" berhasil dipinjam!");
    }

    public function return(Request $request, $borrowId)
    {
        $borrow = Borrow::with('equipment')->findOrFail($borrowId);

        if ($borrow->returned_at) {
            return back()->withErrors(['error' => 'equipment sudah dikembalikan!']);
        }

        // Update borrow record
        $borrow->update(['returned_at' => Carbon::now()]);

        // Update equipment status
        $borrow->equipment->update(['status' => 'available']);

        return back()->with('success', "equipment \"{$borrow->equipment->title}\" berhasil dikembalikan!");
    }
}
