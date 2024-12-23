<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\notifikasiModel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // View::composer('*', function ($view) {
        //     if (auth()->check()) {
        //         $user = auth()->user();
        //         $notifikasi = notifikasiModel::where(function ($query) use ($user) {
        //             $query->where('id_peserta_pelatihan', $user->id)
        //                 ->orWhere('id_peserta_sertifikasi', $user->id);
        //         })->orderBy('created_at', 'desc')->get();

        //         $unreadNotifications = $notifikasi->where('is_read', 0)->count();
        //         $view->with(['notifikasi' => $notifikasi, 'unreadNotifications' => $unreadNotifications]);
        //     }
        // });
    }
}
