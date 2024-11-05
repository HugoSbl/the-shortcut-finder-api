<?php

namespace App\Http\Controllers;

use App\Models\ShortcutProposal;
use Illuminate\Http\Request;

class ShortcutProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(ShortcutProposal::all());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ShortcutProposal $shortcutProposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShortcutProposal $shortcutProposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShortcutProposal $shortcutProposal)
    {
        //
    }
}
