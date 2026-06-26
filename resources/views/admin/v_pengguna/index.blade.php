 @extends('admin.v_layouts.app')

 @section('title', 'Manajemen Pengguna - Admin SIMBO')

 <!-- Page Content -->
 <main class="px-8 py-8">

     <!-- Header Page -->
     <div class="flex items-start justify-between">
         <div>
             <h2 class="text-3xl font-bold tracking-wide">
                 Manajemen Pengguna
             </h2>
             <p class="text-sm text-gray-600 mt-2">
                 Kelola akses dan peran pengguna dalam sistem SIMBO.
             </p>
         </div>

         <button class="bg-[#142C14] text-white px-7 py-3 rounded text-sm font-semibold hover:bg-[#0f220f]">
             + Tambah Pengguna Baru
         </button>
     </div>

     <!-- Filter Box -->
     <div class="mt-8 bg-white border border-[#E5E5E5] rounded-lg p-5">
         <div class="flex items-center gap-4">

             <div class="relative flex-1">
                 <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm">
                     🔍
                 </span>
                 <input type="text" placeholder="Cari nama atau email..."
                     class="w-full h-12 rounded border border-gray-300 pl-11 pr-4 text-sm outline-none focus:border-[#142C14]">
             </div>

             <div class="flex items-center gap-2">
                 <label class="text-sm font-medium">
                     Filter Peran:
                 </label>

                 <select
                     class="h-12 w-40 rounded border border-gray-300 px-4 text-sm outline-none focus:border-[#142C14]">
                     <option>Semua</option>
                     <option>Admin</option>
                     <option>Petugas Lapangan</option>
                 </select>
             </div>

             <button
                 class="h-12 w-12 border border-gray-300 rounded flex items-center justify-center hover:bg-gray-100">
                 ⚙️
             </button>
         </div>
     </div>

     <!-- Table -->
     <div class="mt-6 bg-white border border-[#E5E5E5] rounded-lg overflow-hidden">

         <table class="w-full text-sm">
             <thead class="bg-[#F9FAFB] border-b border-[#E5E5E5]">
                 <tr class="text-left text-xs font-bold tracking-wider text-gray-700 uppercase">
                     <th class="px-6 py-4">Nama</th>
                     <th class="px-6 py-4">Email</th>
                     <th class="px-6 py-4">Peran</th>
                     <th class="px-6 py-4">Status</th>
                     <th class="px-6 py-4">Terakhir Login</th>
                     <th class="px-6 py-4 text-center">Aksi</th>
                 </tr>
             </thead>

             <tbody class="divide-y divide-[#E5E5E5]">

                 <!-- Row 1 -->
                 <tr class="hover:bg-[#F9FAFB]">
                     <td class="px-6 py-5">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-9 h-9 rounded-full bg-green-100 text-[#142C14] flex items-center justify-center text-xs font-semibold">
                                 AP
                             </div>
                             <span class="font-semibold">Agus Pratama</span>
                         </div>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         agus@simbo.id
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded bg-orange-100 text-[#4D2D18] font-medium">
                             Petugas Lapangan
                         </span>
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                             Aktif
                         </span>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         12 Okt 2023
                     </td>

                     <td class="px-6 py-5">
                         <div class="flex items-center justify-center gap-5">
                             <button class="text-[#142C14] hover:opacity-70">✎</button>
                             <button class="text-[#142C14] hover:opacity-70">⌫</button>
                         </div>
                     </td>
                 </tr>

                 <!-- Row 2 -->
                 <tr class="hover:bg-[#F9FAFB]">
                     <td class="px-6 py-5">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-9 h-9 rounded-full bg-orange-100 text-[#4D2D18] flex items-center justify-center text-xs font-semibold">
                                 SA
                             </div>
                             <span class="font-semibold">Siti Aminah</span>
                         </div>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         siti@simbo.id
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded bg-green-100 text-[#142C14] font-medium">
                             Admin
                         </span>
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                             Aktif
                         </span>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         11 Okt 2023
                     </td>

                     <td class="px-6 py-5">
                         <div class="flex items-center justify-center gap-5">
                             <button class="text-[#142C14] hover:opacity-70">✎</button>
                             <button class="text-[#142C14] hover:opacity-70">⌫</button>
                         </div>
                     </td>
                 </tr>

                 <!-- Row 3 -->
                 <tr class="hover:bg-[#F9FAFB]">
                     <td class="px-6 py-5">
                         <div class="flex items-center gap-3">
                             <div
                                 class="w-9 h-9 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center text-xs font-semibold">
                                 BS
                             </div>
                             <span class="font-semibold">Budi Santoso</span>
                         </div>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         budi@simbo.id
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded bg-orange-100 text-[#4D2D18] font-medium">
                             Petugas Lapangan
                         </span>
                     </td>

                     <td class="px-6 py-5">
                         <span class="px-3 py-1 text-xs rounded-full bg-gray-200 text-gray-700 font-medium">
                             Nonaktif
                         </span>
                     </td>

                     <td class="px-6 py-5 text-gray-700">
                         05 Okt 2023
                     </td>

                     <td class="px-6 py-5">
                         <div class="flex items-center justify-center gap-5">
                             <button class="text-[#142C14] hover:opacity-70">✎</button>
                             <button class="text-[#142C14] hover:opacity-70">⌫</button>
                         </div>
                     </td>
                 </tr>

             </tbody>
         </table>

         <!-- Pagination -->
         <div class="flex items-center justify-between px-6 py-5 border-t border-[#E5E5E5]">
             <p class="text-sm text-gray-600">
                 Menampilkan 1 sampai 10 dari 45 entri
             </p>

             <div class="flex items-center gap-2">
                 <button class="w-9 h-9 border border-gray-300 rounded text-gray-500">
                     ‹
                 </button>
                 <button class="w-9 h-9 rounded bg-[#142C14] text-white">
                     1
                 </button>
                 <button class="w-9 h-9 rounded hover:bg-gray-100">
                     2
                 </button>
                 <button class="w-9 h-9 rounded hover:bg-gray-100">
                     3
                 </button>
                 <span class="px-2">...</span>
                 <button class="w-9 h-9 rounded hover:bg-gray-100">
                     5
                 </button>
                 <button class="w-9 h-9 border border-gray-300 rounded">
                     ›
                 </button>
             </div>
         </div>
     </div>

     <!-- Bottom Cards -->
     <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

         <!-- Activity Card -->
         <div class="lg:col-span-2 bg-white border border-[#E5E5E5] rounded-lg p-7 relative overflow-hidden">
             <div class="relative z-10">
                 <h3 class="text-xl font-bold">
                     Laporan Aktivitas Admin
                 </h3>

                 <p class="text-sm text-gray-600 leading-6 mt-3 max-w-xl">
                     Pantau audit log dan perubahan hak akses yang dilakukan oleh
                     tim administrator dalam 24 jam terakhir.
                 </p>

                 <a href="#" class="inline-block mt-5 text-sm font-bold text-[#142C14]">
                     Lihat Audit Log →
                 </a>
             </div>

             <div class="absolute right-8 top-4 text-[130px] text-gray-100 leading-none">
                 ◧
             </div>
         </div>

         <!-- Security Score Card -->
         <div class="bg-[#142C14] rounded-lg p-7 text-white">
             <div class="text-2xl mb-6">
                 ♢
             </div>

             <p class="text-lg font-semibold">
                 Security Score
             </p>

             <div class="flex items-end justify-between mt-2">
                 <h3 class="text-4xl font-extrabold">
                     94%
                 </h3>

                 <span class="px-3 py-1 rounded bg-white/10 text-xs">
                     Excellent
                 </span>
             </div>
         </div>

     </div>

 </main>
