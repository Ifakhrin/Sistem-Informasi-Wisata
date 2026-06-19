<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Saved Travel Plans
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Manage your saved destinations, trips, and itineraries
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 14px 16px; border-radius: 14px; margin-bottom: 22px; font-size: 14px; font-weight: 700;">
                    {{ session('success') }}
                </div>
            @endif

            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px;">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 28px;">
                    <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                        Saved Destinations ({{ $savedPlans->count() }})
                    </h3>
                    @if ($savedPlans->count() > 0)
                        <form action="{{ route('saved-plans.clear') }}"
                            method="POST"
                            style="margin: 0;"
                            onsubmit="return confirm('Hapus semua destinasi dari Saved Plans?')">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    style="background: transparent; border: none; color: #ef4444; font-size: 14px; font-weight: 800; cursor: pointer;">
                                Clear All
                            </button>
                        </form>
                    @endif
                </div>

                @if ($savedPlans->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px;">
                        @foreach ($savedPlans as $savedPlan)
                            @php
                                $destinasi = $savedPlan->destinasi;
                            @endphp
                            @if ($destinasi)
                                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; overflow: hidden;">
                                    @php
                                        $categoryImages = [
                                            'Budaya' => 'budaya.jpg',
                                            'Taman Hiburan' => 'taman_hiburan.jpg',
                                            'Cagar Alam' => 'cagar_alam.jpg',
                                            'Bahari' => 'bahari.jpg',
                                            'Tempat Ibadah' => 'tempat_ibadah.jpg',
                                            'Pusat Perbelanjaan' => 'pusat_perbelanjaan.jpg',
                                        ];

                                        $categoryImage = $categoryImages[$destinasi->kategori] ?? 'cagar_alam.jpg';
                                    @endphp

                                    <!-- Category Image -->
                                    <div style="
                                        height: 190px;
                                        background-image: linear-gradient(rgba(15, 23, 42, 0.10), rgba(15, 23, 42, 0.38)), url('{{ asset('images/categories/' . $categoryImage) }}');
                                        background-size: cover;
                                        background-position: center;
                                        position: relative;
                                        overflow: hidden;
                                    ">

                                        <div style="position: absolute; top: 14px; right: 14px; background: #06b6d4; color: white; width: 42px; height: 42px; border-radius: 999px; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 900;">
                                            ♥
                                        </div>

                                        <div style="position: absolute; left: 14px; bottom: 14px; background: #2563eb; color: white; border-radius: 999px; padding: 7px 12px; font-size: 12px; font-weight: 800;">
                                            AI {{ min(99, 85 + $loop->iteration) }}%
                                        </div>
                                    </div>

                                    <!-- Card Content -->
                                    <div style="padding: 20px;">
                                        <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0 0 8px;">
                                            {{ $destinasi->nama_wisata }}
                                        </h3>

                                        <p style="font-size: 14px; color: #64748b; margin: 0 0 16px;">
                                            {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                                        </p>

                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                                            <div style="font-size: 14px; color: #f59e0b; font-weight: 800;">
                                                ★ {{ $destinasi->rating }}
                                            </div>

                                            <span style="border: 1px solid #e2e8f0; border-radius: 999px; padding: 5px 10px; font-size: 12px; color: #0f172a; font-weight: 700;">
                                                {{ $destinasi->kategori }}
                                            </span>
                                        </div>

                                        <div style="border-top: 1px solid #e2e8f0; padding-top: 14px; display: flex; justify-content: space-between; align-items: center; gap: 12px;">
                                            <div>
                                                <p style="font-size: 12px; color: #64748b; margin: 0;">
                                                    Harga tiket
                                                </p>

                                                <p style="font-size: 15px; color: #0f172a; font-weight: 900; margin: 4px 0 0;">
                                                    @if ($destinasi->harga_tiket == 0)
                                                        Gratis
                                                    @else
                                                        Rp {{ number_format($destinasi->harga_tiket, 0, ',', '.') }}
                                                    @endif
                                                </p>
                                            </div>

                                            <p style="font-size: 12px; color: #64748b; margin: 0;">
                                                {{ $savedPlan->created_at->diffForHumans() }}
                                            </p>
                                        </div>

                                        <div style="display: flex; gap: 10px; margin-top: 18px;">
                                            <a href="{{ route('destinasi.show', $destinasi->id) }}"
                                               style="flex: 1; background: #2563eb; color: white; text-align: center; padding: 11px 14px; border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none;">
                                                Detail
                                            </a>

                                            <form action="{{ route('saved-plans.destroy', $savedPlan->id) }}"
                                                  method="POST"
                                                  style="margin: 0;"
                                                  onsubmit="return confirm('Hapus destinasi ini dari Saved Plans?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        style="background: #fee2e2; color: #dc2626; border: none; padding: 11px 14px; border-radius: 12px; font-size: 14px; font-weight: 800; cursor: pointer;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 56px 24px; background: #f8fafc; border-radius: 20px; border: 1px dashed #cbd5e1;">
                        <div style="font-size: 44px; margin-bottom: 14px;">
                        </div>

                        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 8px;">
                            Belum ada destinasi yang disimpan
                        </h3>

                        <p style="font-size: 14px; color: #64748b; margin: 0 0 20px;">
                            Simpan destinasi dari halaman Explore agar muncul di sini.
                        </p>

                        <a href="{{ route('destinasi.index') }}"
                           style="display: inline-block; background: #2563eb; color: white; padding: 12px 18px; border-radius: 12px; font-weight: 800; text-decoration: none;">
                            Explore Destinations
                        </a>
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>