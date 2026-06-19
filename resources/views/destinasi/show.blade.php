<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Destination Details
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Detailed information about {{ $destinasi->nama_wisata }}
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="margin-bottom: 22px;">
                <a href="{{ route('destinasi.index') }}"
                   style="display: inline-flex; align-items: center; gap: 8px; color: #334155; font-size: 14px; font-weight: 800; text-decoration: none;">
                    ← Back to Explore
                </a>
            </div>

            @if (session('success'))
                <div style="background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; padding: 14px 16px; border-radius: 14px; margin-bottom: 22px; font-size: 14px; font-weight: 700;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Hero Section -->
            <div style="background: white; border: 1px solid #e2e8f0; border-radius: 26px; overflow: hidden; margin-bottom: 28px;">

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

                <div style="
                    height: 360px;
                    background-image: linear-gradient(rgba(15, 23, 42, 0.25), rgba(15, 23, 42, 0.55)), url('{{ asset('images/categories/' . $categoryImage) }}');
                    background-size: cover;
                    background-position: center;
                    position: relative;
                    display: flex;
                    align-items: flex-end;
                    justify-content: flex-start;
                    padding: 32px;
                ">

                    <div style="color: white;">
                        <p style="font-size: 14px; font-weight: 800; opacity: 0.95; margin: 0 0 10px;">
                            {{ $destinasi->kategori }}
                        </p>

                        <h1 style="font-size: 42px; font-weight: 900; margin: 0 0 10px; line-height: 1.1;">
                            {{ $destinasi->nama_wisata }}
                        </h1>

                        <p style="font-size: 16px; margin: 0; opacity: 0.95;">
                            {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                        </p>
                    </div>

                    <div style="position: absolute; top: 20px; left: 20px; background: rgba(255,255,255,0.94); color: #0f172a; padding: 8px 14px; border-radius: 999px; font-size: 13px; font-weight: 800;">
                        {{ $destinasi->kategori }}
                    </div>

                    <div style="position: absolute; top: 20px; right: 20px; background: rgba(255,255,255,0.94); color: #f59e0b; padding: 8px 14px; border-radius: 999px; font-size: 13px; font-weight: 800;">
                        ★ {{ $destinasi->rating }}
                    </div>
                </div>

                <div style="padding: 28px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 24px;">
                        <div>
                            <h1 style="font-size: 32px; font-weight: 900; color: #0f172a; margin: 0 0 10px;">
                                {{ $destinasi->nama_wisata }}
                            </h1>

                            <p style="font-size: 15px; color: #64748b; margin: 0;">
                                {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                            </p>
                        </div>

                        <div style="display: flex; gap: 10px; align-items: center;">
                            <form class="save-toggle-form"
                                method="POST"
                                action="{{ route('saved-plans.store', $destinasi->id) }}"
                                data-saved="{{ $isSaved ? '1' : '0' }}"
                                style="margin: 0;">
                                @csrf

                                <button
                                    type="submit"
                                    class="save-toggle-button"
                                    title="{{ $isSaved ? 'Hapus dari Saved Plans' : 'Simpan ke Saved Plans' }}"
                                    style="
                                        min-width: 120px;
                                        height: 44px;
                                        padding: 0 18px;
                                        border-radius: 12px;
                                        border: none;
                                        background: {{ $isSaved ? '#16a34a' : '#2563eb' }};
                                        color: white;
                                        font-size: 14px;
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
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 28px;">

                <!-- Left Content -->
                <div style="display: flex; flex-direction: column; gap: 24px;">

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 26px;">
                        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 14px;">
                            About This Destination
                        </h3>

                        <p style="font-size: 15px; color: #475569; line-height: 1.8; margin: 0;">
                            {{ $destinasi->deskripsi ?? 'Belum ada deskripsi detail untuk destinasi ini.' }}
                        </p>
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 26px;">
                        <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 18px;">
                            AI Travel Insight
                        </h3>

                        <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 18px; padding: 18px;">
                            <p style="font-size: 14px; color: #1e3a8a; line-height: 1.7; margin: 0;">
                                Destinasi ini cocok untuk pengguna yang mencari wisata kategori {{ $destinasi->kategori }}
                                di wilayah {{ $destinasi->provinsi }}. Dengan rating {{ $destinasi->rating }},
                                destinasi ini dapat menjadi salah satu pilihan prioritas dalam rekomendasi sistem.
                            </p>
                        </div>
                    </div>

                </div>

                <!-- Right Sidebar -->
                <div style="display: flex; flex-direction: column; gap: 24px;">

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0 0 18px;">
                            Destination Info
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 16px;">

                            <div>
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Category
                                </p>
                                <p style="font-size: 15px; color: #0f172a; margin: 0; font-weight: 800;">
                                    {{ $destinasi->kategori }}
                                </p>
                            </div>

                            <div>
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Location
                                </p>
                                <p style="font-size: 15px; color: #0f172a; margin: 0; font-weight: 800;">
                                    {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                                </p>
                            </div>

                            <div>
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Rating
                                </p>
                                <p style="font-size: 15px; color: #f59e0b; margin: 0; font-weight: 900;">
                                    ★ {{ $destinasi->rating }}
                                </p>
                            </div>

                            <div>
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Ticket Price
                                </p>
                                <p style="font-size: 15px; color: #0f172a; margin: 0; font-weight: 900;">
                                    @if ($destinasi->harga_tiket == 0)
                                        Gratis
                                    @else
                                        Rp {{ number_format($destinasi->harga_tiket, 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 900; color: #0f172a; margin: 0 0 18px;">
                            Map Coordinate
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div style="background: #f8fafc; border-radius: 14px; padding: 14px;">
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Latitude
                                </p>
                                <p style="font-size: 14px; color: #0f172a; margin: 0; font-weight: 800;">
                                    {{ $destinasi->latitude ?? '-' }}
                                </p>
                            </div>

                            <div style="background: #f8fafc; border-radius: 14px; padding: 14px;">
                                <p style="font-size: 12px; color: #64748b; margin: 0 0 4px; font-weight: 700;">
                                    Longitude
                                </p>
                                <p style="font-size: 14px; color: #0f172a; margin: 0; font-weight: 800;">
                                    {{ $destinasi->longitude ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div style="background: linear-gradient(135deg, #2563eb, #06b6d4); border-radius: 22px; padding: 24px; color: white;">
                        <h3 style="font-size: 18px; font-weight: 900; margin: 0 0 10px;">
                            Need Similar Places?
                        </h3>

                        <p style="font-size: 14px; line-height: 1.6; opacity: 0.95; margin: 0 0 18px;">
                            Ask AI Assistant to recommend destinations similar to this place.
                        </p>

                        <a href="{{ route('ai-assistant.index') }}"
                           style="display: block; background: white; color: #2563eb; text-align: center; padding: 11px 14px; border-radius: 14px; font-size: 14px; font-weight: 900; text-decoration: none;">
                            Ask AI Assistant
                        </a>
                    </div>

                </div>
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