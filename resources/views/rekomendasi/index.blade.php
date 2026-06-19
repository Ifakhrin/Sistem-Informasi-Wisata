<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                AI Recommendation
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Get destination recommendations based on your travel preferences
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Preference Form -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px; margin-bottom: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px; margin-bottom: 24px;">
                    <div>
                        <h3 style="font-size: 22px; font-weight: 900; color: #0f172a; margin: 0 0 8px;">
                            Find Your Best Destination
                        </h3>

                        <p style="font-size: 14px; color: #64748b; margin: 0; line-height: 1.6;">
                            Select your preferred category and maximum budget. The system calculates AI Match Score using category preference, budget suitability, dataset average rating, and destination popularity based on total reviews.
                        </p>
                    </div>

                    <div style="background: #eff6ff; color: #2563eb; padding: 10px 14px; border-radius: 999px; font-size: 13px; font-weight: 900; white-space: nowrap;">
                        AI Scoring Mode
                    </div>
                </div>

                <form method="POST" action="{{ route('rekomendasi.proses') }}">
                    @csrf

                    <div style="display: grid; grid-template-columns: 1fr 1fr auto; gap: 16px; align-items: end;">
                        <div>
                            <label style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                                Kategori Wisata
                            </label>

                            <select
                                name="kategori"
                                style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #334155;">
                                <option value="">Semua Kategori</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori }}" {{ old('kategori', $selectedKategori) == $kategori ? 'selected' : '' }}>
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>

                            @error('kategori')
                                <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                                Budget Maksimal
                            </label>

                            <input
                                type="number"
                                name="budget"
                                value="{{ old('budget', $selectedBudget) }}"
                                placeholder="Contoh: 50000"
                                min="0"
                                style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; outline: none;"
                            >

                            @error('budget')
                                <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button
                            type="submit"
                            style="background: #2563eb; color: white; border: none; border-radius: 14px; padding: 12px 18px; font-weight: 900; cursor: pointer; height: 46px;">
                            Generate Recommendation
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preference Summary -->
            @if ($selectedKategori || $selectedBudget !== null)
                <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 24px;">
                    @if ($selectedKategori)
                        <span style="background: #dbeafe; color: #1d4ed8; border-radius: 999px; padding: 8px 13px; font-size: 13px; font-weight: 800;">
                            Category: {{ $selectedKategori }}
                        </span>
                    @endif

                    @if ($selectedBudget !== null && $selectedBudget !== '')
                        <span style="background: #dcfce7; color: #166534; border-radius: 999px; padding: 8px 13px; font-size: 13px; font-weight: 800;">
                            Max Budget: Rp {{ number_format($selectedBudget, 0, ',', '.') }}
                        </span>
                    @endif

                    <a href="{{ route('rekomendasi.index') }}"
                       style="background: white; color: #334155; border: 1px solid #e2e8f0; border-radius: 999px; padding: 8px 13px; font-size: 13px; font-weight: 800; text-decoration: none;">
                        Reset
                    </a>
                </div>
            @endif

            <!-- Recommendation Results -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 26px;">
                    <div>
                        <h3 style="font-size: 22px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
                            AI Recommendation Results
                        </h3>

                        <p style="font-size: 14px; color: #64748b; margin: 0;">
                            {{ $rekomendasis->count() }} destinations ranked using dataset-based recommendation scoring
                        </p>
                    </div>

                    <span style="background: #06b6d4; color: white; border-radius: 999px; padding: 8px 13px; font-size: 12px; font-weight: 900;">
                        Ranked by Score
                    </span>
                </div>

                @if ($rekomendasis->count() > 0)
                    <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 24px;">
                        @foreach ($rekomendasis as $rekomendasi)
                            @php
                                $isSaved = in_array($rekomendasi->id, $savedDestinasiIds ?? []);

                                $categoryImages = [
                                    'Budaya' => 'budaya.jpg',
                                    'Taman Hiburan' => 'taman_hiburan.jpg',
                                    'Cagar Alam' => 'cagar_alam.jpg',
                                    'Bahari' => 'bahari.jpg',
                                    'Tempat Ibadah' => 'tempat_ibadah.jpg',
                                    'Pusat Perbelanjaan' => 'pusat_perbelanjaan.jpg',
                                ];

                                $categoryImage = $categoryImages[$rekomendasi->kategori] ?? 'cagar_alam.jpg';
                            @endphp

                            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; overflow: hidden;">

                                <!-- Category Image -->
                                <div style="
                                    height: 190px;
                                    background-image: linear-gradient(rgba(15, 23, 42, 0.10), rgba(15, 23, 42, 0.38)), url('{{ asset('images/categories/' . $categoryImage) }}');
                                    background-size: cover;
                                    background-position: center;
                                    position: relative;
                                    overflow: hidden;
                                ">
                                    <div style="position: absolute; top: 14px; left: 14px; background: rgba(255,255,255,0.94); color: #0f172a; padding: 6px 11px; border-radius: 999px; font-size: 12px; font-weight: 900;">
                                        {{ $rekomendasi->kategori }}
                                    </div>

                                    <div style="position: absolute; top: 14px; right: 14px; background: #2563eb; color: white; padding: 6px 11px; border-radius: 999px; font-size: 12px; font-weight: 900;">
                                        {{ $rekomendasi->recommendation_score }}% Match
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div style="padding: 20px;">
                                    <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0 0 8px;">
                                        {{ $rekomendasi->nama_wisata }}
                                    </h3>

                                    <p style="font-size: 14px; color: #64748b; margin: 0 0 14px;">
                                        {{ $rekomendasi->kota }}, {{ $rekomendasi->provinsi }}
                                    </p>

                                    <p style="font-size: 14px; color: #475569; line-height: 1.6; margin: 0 0 16px;">
                                        {{ \Illuminate\Support\Str::limit($rekomendasi->deskripsi ?? 'Destinasi wisata yang sesuai dengan preferensi pengguna berdasarkan sistem rekomendasi.', 95) }}
                                    </p>

                                    <div style="background: #f8fafc; border-radius: 16px; padding: 14px; margin-bottom: 16px;">
                                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                            <span style="font-size: 13px; color: #64748b; font-weight: 800;">
                                                AI Match Score
                                            </span>
                                            <span style="font-size: 14px; color: #2563eb; font-weight: 900;">
                                                {{ $rekomendasi->recommendation_score }}%
                                            </span>
                                        </div>

                                        <div style="height: 8px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                            <div style="height: 100%; width: {{ min(100, $rekomendasi->recommendation_score) }}%; background: #2563eb; border-radius: 999px;"></div>
                                        </div>
                                    </div>

                                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 18px;">
                                        <div style="background: #f8fafc; border-radius: 14px; padding: 12px;">
                                            <p style="font-size: 11px; color: #64748b; margin: 0 0 5px; font-weight: 700;">
                                                Ticket
                                            </p>

                                            <p style="font-size: 13px; font-weight: 900; color: #0f172a; margin: 0;">
                                                @if ($rekomendasi->harga_tiket == 0)
                                                    Gratis
                                                @else
                                                    Rp {{ number_format($rekomendasi->harga_tiket, 0, ',', '.') }}
                                                @endif
                                            </p>
                                        </div>

                                        <div style="background: #f8fafc; border-radius: 14px; padding: 12px;">
                                            <p style="font-size: 11px; color: #64748b; margin: 0 0 5px; font-weight: 700;">
                                                Rating
                                            </p>

                                            <p style="font-size: 13px; font-weight: 900; color: #f59e0b; margin: 0;">
                                                ★ {{ $rekomendasi->dataset_average_rating ?? $rekomendasi->rating }}
                                            </p>
                                        </div>

                                        <div style="background: #f8fafc; border-radius: 14px; padding: 12px;">
                                            <p style="font-size: 11px; color: #64748b; margin: 0 0 5px; font-weight: 700;">
                                                Reviews
                                            </p>

                                            <p style="font-size: 13px; font-weight: 900; color: #0f172a; margin: 0;">
                                                {{ $rekomendasi->dataset_total_rating ?? 0 }}
                                            </p>
                                        </div>
                                    </div>

                                    <div style="display: flex; gap: 10px;">
                                        <a href="{{ route('destinasi.show', $rekomendasi->id) }}"
                                           style="flex: 1; background: #2563eb; color: white; text-align: center; padding: 12px 14px; border-radius: 12px; font-size: 14px; font-weight: 900; text-decoration: none;">
                                            Detail
                                        </a>

                                        <form
                                            class="save-toggle-form"
                                            method="POST"
                                            action="{{ route('saved-plans.store', $rekomendasi->id) }}"
                                            data-saved="{{ $isSaved ? '1' : '0' }}"
                                            style="margin: 0;"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="save-toggle-button"
                                                title="{{ $isSaved ? 'Hapus dari Saved Plans' : 'Simpan ke Saved Plans' }}"
                                                style="
                                                    min-width: 82px;
                                                    height: 44px;
                                                    padding: 0 14px;
                                                    border-radius: 12px;
                                                    border: none;
                                                    background: {{ $isSaved ? '#16a34a' : '#2563eb' }};
                                                    color: white;
                                                    font-size: 13px;
                                                    font-weight: 900;
                                                    cursor: pointer;
                                                ">
                                                {{ $isSaved ? 'Saved' : 'Save' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 56px 24px; background: #f8fafc; border-radius: 20px; border: 1px dashed #cbd5e1;">
                        <div style="font-size: 44px; margin-bottom: 14px;">
                            🤖
                        </div>

                        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 8px;">
                            Belum ada rekomendasi
                        </h3>

                        <p style="font-size: 14px; color: #64748b; margin: 0 0 20px;">
                            Pilih kategori dan budget terlebih dahulu untuk mendapatkan rekomendasi destinasi.
                        </p>

                        <a href="{{ route('ai-assistant.index') }}"
                           style="display: inline-block; background: #2563eb; color: white; padding: 12px 18px; border-radius: 12px; font-weight: 900; text-decoration: none;">
                            Ask AI Assistant
                        </a>
                    </div>
                @endif
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