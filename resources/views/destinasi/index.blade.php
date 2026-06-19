<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Explore Destinations
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Discover {{ $destinasis->count() }} amazing places across Indonesia
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Filter Box -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 24px; margin-bottom: 28px;">
                <form method="GET" action="{{ route('destinasi.index') }}">
                    <div style="display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr auto; gap: 14px; align-items: center;">

                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search destinations..."
                            style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; outline: none;"
                        >

                        <select
                            name="kategori"
                            style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #334155;">
                            <option value="">All Categories</option>
                            @foreach ($kategoris as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>

                        <select
                            name="provinsi"
                            style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #334155;">
                            <option value="">All Provinces</option>
                            @foreach ($provinsis as $provinsi)
                                <option value="{{ $provinsi }}" {{ request('provinsi') == $provinsi ? 'selected' : '' }}>
                                    {{ $provinsi }}
                                </option>
                            @endforeach
                        </select>

                        <select
                            name="budget"
                            style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #334155;">
                            <option value="">All Budgets</option>
                            <option value="free" {{ request('budget') == 'free' ? 'selected' : '' }}>
                                Gratis
                            </option>
                            <option value="low" {{ request('budget') == 'low' ? 'selected' : '' }}>
                                Rp 1 - Rp 50.000
                            </option>
                            <option value="medium" {{ request('budget') == 'medium' ? 'selected' : '' }}>
                                Rp 50.001 - Rp 150.000
                            </option>
                            <option value="high" {{ request('budget') == 'high' ? 'selected' : '' }}>
                                &gt; Rp 150.000
                            </option>
                        </select>

                        <button
                            type="submit"
                            style="background: #2563eb; color: white; border: none; border-radius: 14px; padding: 12px 18px; font-weight: 700; cursor: pointer;">
                            Filter
                        </button>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 18px; padding-top: 18px; border-top: 1px solid #e2e8f0;">
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <span style="background: #06b6d4; color: white; border-radius: 999px; padding: 7px 12px; font-size: 12px; font-weight: 700;">
                                AI Recommended
                            </span>

                            <span style="background: #06b6d4; color: white; border-radius: 999px; padding: 7px 12px; font-size: 12px; font-weight: 700;">
                                Trending
                            </span>

                            <span style="background: #06b6d4; color: white; border-radius: 999px; padding: 7px 12px; font-size: 12px; font-weight: 700;">
                                Top Rated
                            </span>
                        </div>

                        <a href="{{ route('destinasi.index') }}"
                           style="color: #334155; font-size: 14px; font-weight: 700; text-decoration: none;">
                            Reset Filters
                        </a>
                    </div>
                </form>
            </div>

            <!-- Destination Grid -->
            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px;">
                @forelse ($destinasis as $destinasi)
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; overflow: hidden;">

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

                            <div style="position: absolute; top: 14px; left: 14px; background: rgba(255,255,255,0.92); color: #0f172a; padding: 6px 11px; border-radius: 999px; font-size: 12px; font-weight: 800;">
                                {{ $destinasi->kategori }}
                            </div>

                            <div style="position: absolute; top: 14px; right: 14px; background: rgba(255,255,255,0.92); color: #f59e0b; padding: 6px 11px; border-radius: 999px; font-size: 12px; font-weight: 800;">
                                ☆ {{ $destinasi->rating }}
                            </div>

                        </div>

                        <!-- Card Content -->
                        <div style="padding: 20px;">
                            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">
                                {{ $destinasi->nama_wisata }}
                            </h3>

                            <p style="font-size: 14px; color: #64748b; margin: 0 0 14px;">
                                {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                            </p>

                            <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0 0 16px;">
                                {{ \Illuminate\Support\Str::limit($destinasi->deskripsi ?? 'Destinasi wisata menarik yang tersedia dalam sistem rekomendasi Travel Insight AI.', 95) }}
                            </p>

                            <div style="display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 18px;">
                                <div style="min-width: 0;">
                                    <p style="font-size: 12px; color: #64748b; margin: 0;">
                                        Harga tiket
                                    </p>

                                    <p style="font-size: 15px; font-weight: 800; color: #0f172a; margin: 4px 0 0;">
                                        @if ($destinasi->harga_tiket == 0)
                                            Gratis
                                        @else
                                            Rp {{ number_format($destinasi->harga_tiket, 0, ',', '.') }}
                                        @endif
                                    </p>
                                </div>

                                @php
                                    $isSaved = in_array($destinasi->id, $savedDestinasiIds ?? []);
                                @endphp

                                <form class="save-toggle-form"
                                    method="POST"
                                    action="{{ route('saved-plans.store', $destinasi->id) }}"
                                    data-saved="{{ $isSaved ? '1' : '0' }}"
                                    style="margin: 0; flex-shrink: 0;">
                                    @csrf

                                    <button
                                        type="submit"
                                        class="save-toggle-button"
                                        title="{{ $isSaved ? 'Hapus dari Saved Plans' : 'Simpan ke Saved Plans' }}"
                                        style="
                                            min-width: 86px;
                                            height: 42px;
                                            padding: 0 16px;
                                            border-radius: 12px;
                                            border: none;
                                            background: {{ $isSaved ? '#16a34a' : '#2563eb' }};
                                            color: white;
                                            font-size: 13px;
                                            font-weight: 800;
                                            cursor: pointer;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                        ">
                                        {{ $isSaved ? 'Saved' : 'Save' }}
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('destinasi.show', $destinasi->id) }}"
                            style="display: block; width: 100%; box-sizing: border-box; background: #2563eb; color: white; text-align: center; padding: 13px 14px; border-radius: 14px; font-weight: 800; text-decoration: none;">
                                View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 32px; text-align: center;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 8px;">
                            Belum ada destinasi yang ditemukan
                        </h3>

                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            Coba ubah kata kunci pencarian atau reset filter.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- AI Assistant CTA -->
            <div style="background: linear-gradient(135deg, #2563eb, #06b6d4); border-radius: 24px; padding: 32px; margin-top: 32px; color: white; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="font-size: 24px; font-weight: 800; margin: 0 0 8px;">
                        Can’t find what you’re looking for?
                    </h3>

                    <p style="font-size: 15px; opacity: 0.95; margin: 0;">
                        Ask our AI Assistant to help you discover destinations based on your preferences.
                    </p>
                </div>

                <a href="{{ route('ai-assistant.index') }}"
                   style="background: white; color: #2563eb; padding: 12px 18px; border-radius: 14px; font-weight: 800; text-decoration: none;">
                    Ask AI Assistant
                </a>
            </div>

        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const saveForms = document.querySelectorAll('.save-toggle-form');

            saveForms.forEach(function (form) {
                form.addEventListener('submit', async function (event) {
                    event.preventDefault();

                    const button = form.querySelector('.save-toggle-button');
                    const token = form.querySelector('input[name="_token"]').value;
                    const originalText = button.textContent.trim();

                    button.disabled = true;
                    button.textContent = 'Loading...';
                    button.style.opacity = '0.75';

                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: new FormData(form)
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Request gagal.');
                        }

                        if (data.saved) {
                            form.dataset.saved = '1';
                            button.textContent = 'Saved';
                            button.style.background = '#16a34a';
                            button.title = 'Hapus dari Saved Plans';
                        } else {
                            form.dataset.saved = '0';
                            button.textContent = 'Save';
                            button.style.background = '#2563eb';
                            button.title = 'Simpan ke Saved Plans';
                        }
                    } catch (error) {
                        button.textContent = originalText;
                        alert('Gagal mengubah status Saved Plans. Coba lagi.');
                    } finally {
                        button.disabled = false;
                        button.style.opacity = '1';
                    }
                });
            });
        });
    </script>
</x-app-layout>