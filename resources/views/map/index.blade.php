<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Tourism Map
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Explore destination locations across Indonesia
            </p>
        </div>
    </x-slot>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Summary Cards -->
            <div style="display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 20px; margin-bottom: 24px;">
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 22px;">
                    <p style="font-size: 14px; color: #64748b; margin: 0 0 8px; font-weight: 700;">
                        Total Destinations
                    </p>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0f172a; margin: 0;">
                        {{ $destinasis->count() }}
                    </h3>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 22px;">
                    <p style="font-size: 14px; color: #64748b; margin: 0 0 8px; font-weight: 700;">
                        Map Coverage
                    </p>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0f172a; margin: 0;">
                        Indonesia
                    </h3>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 20px; padding: 22px;">
                    <p style="font-size: 14px; color: #64748b; margin: 0 0 8px; font-weight: 700;">
                        Data Source
                    </p>
                    <h3 style="font-size: 28px; font-weight: 900; color: #0f172a; margin: 0;">
                        System
                    </h3>
                </div>
            </div>

            <!-- Map Layout -->
            <div style="display: grid; grid-template-columns: 2fr 0.9fr; gap: 24px; align-items: start;">

                <!-- Map Card -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px;">
                        <div>
                            <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0;">
                                Destination Distribution Map
                            </h3>
                            <p style="font-size: 14px; color: #64748b; margin: 6px 0 0;">
                                Click a marker to see destination details.
                            </p>
                        </div>

                        <span style="background: #dbeafe; color: #2563eb; padding: 8px 12px; border-radius: 999px; font-size: 12px; font-weight: 900;">
                            Live Map
                        </span>
                    </div>

                    <div id="map"
                         style="height: 560px; width: 100%; border-radius: 20px; overflow: hidden; border: 1px solid #e2e8f0;">
                    </div>
                </div>

                <!-- Sidebar List -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 24px;">
                    <h3 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
                        Destinations
                    </h3>

                    <p style="font-size: 14px; color: #64748b; margin: 0 0 20px;">
                        Locations available on the map.
                    </p>

                    <div style="display: flex; flex-direction: column; gap: 14px; max-height: 560px; overflow-y: auto; padding-right: 4px;">
                        @forelse ($destinasis as $destinasi)
                            <a href="{{ route('destinasi.show', $destinasi->id) }}"
                               style="display: block; border: 1px solid #e2e8f0; border-radius: 16px; padding: 14px; text-decoration: none; background: #f8fafc;">
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                                    <div>
                                        <h4 style="font-size: 15px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
                                            {{ $destinasi->nama_wisata }}
                                        </h4>

                                        <p style="font-size: 13px; color: #64748b; margin: 0 0 8px;">
                                            {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                                        </p>

                                        <span style="display: inline-block; background: white; border: 1px solid #e2e8f0; color: #334155; padding: 5px 9px; border-radius: 999px; font-size: 11px; font-weight: 800;">
                                            {{ $destinasi->kategori }}
                                        </span>
                                    </div>

                                    <div style="font-size: 13px; color: #f59e0b; font-weight: 900; white-space: nowrap;">
                                        ★ {{ $destinasi->rating }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div style="text-align: center; padding: 32px 18px; background: #f8fafc; border-radius: 16px; border: 1px dashed #cbd5e1;">
                                <p style="font-size: 14px; color: #64748b; margin: 0;">
                                    Belum ada destinasi dengan koordinat.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-2.5489, 118.0149], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        const destinasis = @json($destinasis);
        const detailBaseUrl = "{{ url('/destinasi') }}";

        const markers = [];

        destinasis.forEach(function(destinasi) {
            if (destinasi.latitude && destinasi.longitude) {
                const marker = L.marker([destinasi.latitude, destinasi.longitude])
                    .addTo(map)
                    .bindPopup(`
                        <div style="min-width: 210px;">
                            <h3 style="font-size: 16px; font-weight: 800; margin: 0 0 8px; color: #0f172a;">
                                ${destinasi.nama_wisata}
                            </h3>

                            <p style="font-size: 13px; margin: 0 0 5px; color: #475569;">
                                <strong>Kategori:</strong> ${destinasi.kategori}
                            </p>

                            <p style="font-size: 13px; margin: 0 0 5px; color: #475569;">
                                <strong>Lokasi:</strong> ${destinasi.kota}, ${destinasi.provinsi}
                            </p>

                            <p style="font-size: 13px; margin: 0 0 5px; color: #475569;">
                                <strong>Rating:</strong> ${destinasi.rating}
                            </p>

                            <p style="font-size: 13px; margin: 0 0 12px; color: #475569;">
                                <strong>Harga Tiket:</strong> Rp ${Number(destinasi.harga_tiket).toLocaleString('id-ID')}
                            </p>

                            <a href="${detailBaseUrl}/${destinasi.id}"
                               style="display: block; background: #2563eb; color: white; text-align: center; padding: 8px 10px; border-radius: 10px; font-size: 13px; font-weight: 800; text-decoration: none;">
                                View Details
                            </a>
                        </div>
                    `);

                markers.push(marker);
            }
        });

        if (markers.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.2));
        }
    </script>
</x-app-layout>