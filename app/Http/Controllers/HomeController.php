<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Constellation;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Get statistics for display
        $stats = [
            'active_users' => User::active()->count(),
            'total_transactions' => Transaction::completed()->count(),
            'active_constellations' => Constellation::active()->count(),
            'total_distributed' => Transaction::completed()
                ->where('type', 'payout')
                ->sum('amount'),
        ];

        // Get constellation configuration
        $constellations = [
            'triangulum' => config('7ensemble.constellations.triangulum'),
            'pleiades' => config('7ensemble.constellations.pleiades'),
        ];

        // Get countries for dropdown
        $countries = config('countries');

        // Payment methods
        $paymentMethods = config('payment.supported_methods');

        return view('pages.index', compact('stats', 'constellations', 'countries', 'paymentMethods'));
    }

    /**
     * Handle FAQ page.
     */
    public function faq()
    {
        return view('pages.faq');
    }

    /**
     * Handle contact page.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle terms page.
     */
    public function terms()
    {
        return view('pages.terms');
    }

    /**
     * Handle privacy page.
     */
    public function privacy()
    {
        return view('pages.privacy');
    }

    /**
     * Handle legal page.
     */
    public function legal()
    {
        return view('pages.legal');
    }

    /**
     * Handle referral link.
     */
    public function referral($code)
    {
        $user = User::where('referral_code', $code)->first();

        if ($user) {
            session(['referral_code' => $code]);
            return redirect()->route('register')
                ->with('success', "Vous avez été invité par {$user->name}!");
        }

        return redirect()->route('home')
            ->with('error', 'Code de parrainage invalide.');
    }

    /**
     * Check constellation availability (AJAX).
     */
    public function checkAvailability($type)
    {
        $available = Constellation::where('type', $type)
            ->where('status', 'forming')
            ->whereRaw('current_members < max_members')
            ->exists();

        $count = Constellation::where('type', $type)
            ->where('status', 'forming')
            ->whereRaw('current_members < max_members')
            ->count();

        return response()->json([
            'available' => $available,
            'count' => $count,
        ]);
    }

    /**
     * Validate referral code (AJAX).
     */
    public function validateReferral($code)
    {
        $user = User::where('referral_code', $code)->first();

        return response()->json([
            'valid' => $user ? true : false,
            'referrer_name' => $user ? $user->name : null,
        ]);
    }
}
