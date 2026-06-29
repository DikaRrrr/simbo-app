<?php

namespace App\Providers;

use App\Models\Laporan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        Paginator::useTailwind();

        // Data notifikasi tersedia di semua view admin
        View::composer('admin.v_layouts.app', function ($view) {
            $notifikasi = Laporan::with('kategori')
                ->whereIn('status_laporan', ['Menunggu', 'Diproses'])
                ->latest()
                ->take(8)
                ->get()
                ->map(fn($l) => [
                    'id'      => $l->id_laporan,
                    'judul'   => $l->judul_laporan,
                    'status'  => $l->status_laporan,
                    'waktu'   => $l->created_at->diffForHumans(),
                    'tiket'   => '#RPT-' . str_pad($l->id_laporan, 4, '0', STR_PAD_LEFT),
                    'url'     => url('/admin/identifikasi/detail/' . $l->id_laporan),
                ]);

            $jumlahNotif = Laporan::where('status_laporan', 'Menunggu')->count();

            $view->with(compact('notifikasi', 'jumlahNotif'));
        });
    }

}
