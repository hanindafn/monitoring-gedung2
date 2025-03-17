<?php

// namespace App\Http\Responses\Auth;

// use Filament\Http\Responses\Auth\LoginResponse;
// use Illuminate\Http\RedirectResponse;
// use Livewire\Features\SupportRedirects\Redirector;

// class CustomLoginResponse extends LoginResponse
// {
//     public function toResponse($request): RedirectResponse|Redirector
//     {
//         $user = auth()->user();

//         if ($user->is_admin) {
//             return redirect()->route('filament.admin.pages.dashboard'); // Admin ke dashboard admin
//         }

//         return redirect()->route('filament.pengguna.pages.dashboard'); // Pengguna ke dashboard pengguna
//     }
// }
