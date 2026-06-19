<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Welcome, {{ Auth::user()->name }}!
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Here's what's happening with your travel journey today
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Statistic Cards -->
            <div style="display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 20px; margin-bottom: 28px;">

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <p style="font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 28px;">
                                Total Destinations
                            </p>
                            <h3 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0;">
                                {{ number_format($totalDestinasi) }}
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin-top: 6px;">
                                Available in system
                            </p>
                        </div>

                        <div style="width: 38px; height: 38px; border-radius: 999px; background: #dbeafe; display: flex; align-items: center; justify-content: center;">
                            📍
                        </div>
                    </div>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <p style="font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 28px;">
                                Total Categories
                            </p>
                            <h3 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0;">
                                {{ $totalKategori }}
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin-top: 6px;">
                                Category groups
                            </p>
                        </div>

                        <div style="width: 38px; height: 38px; border-radius: 999px; background: #ccfbf1; display: flex; align-items: center; justify-content: center;">
                            ◎
                        </div>
                    </div>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <p style="font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 28px;">
                                Saved Recommendations
                            </p>
                            <h3 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0;">
                                {{ $totalSavedPlans }}
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin-top: 6px;">
                                Saved by you
                            </p>
                        </div>

                        <div style="width: 38px; height: 38px; border-radius: 999px; background: #dcfce7; display: flex; align-items: center; justify-content: center;">
                            ♡
                        </div>
                    </div>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <p style="font-size: 14px; font-weight: 600; color: #334155; margin-bottom: 28px;">
                                User Travel Score
                            </p>
                            <h3 style="font-size: 30px; font-weight: 800; color: #0f172a; margin: 0;">
                                {{ $userTravelScore }}
                            </h3>
                            <p style="font-size: 12px; color: #64748b; margin-top: 6px;">
                                Personal score
                            </p>
                        </div>

                        <div style="width: 38px; height: 38px; border-radius: 999px; background: #fef3c7; display: flex; align-items: center; justify-content: center;">
                            ☆
                        </div>
                    </div>
                </div>

            </div>

            <!-- Main Dashboard Grid -->
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 28px;">

                <!-- Travel Activity -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                            Travel Activity
                        </h3>
                        <p style="font-size: 14px; color: #64748b; margin-top: 4px;">
                            Aktivitas penyimpanan rencana perjalanan dalam 7 hari terakhir.
                        </p>
                    </div>

                    <div style="height: 300px;">
                        <canvas id="travelActivityChart"></canvas>
                    </div>
                </div>

                <!-- Trending Categories -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                            Trending Categories
                        </h3>
                        <p style="font-size: 14px; color: #64748b; margin-top: 4px;">
                            Kategori berdasarkan jumlah destinasi.
                        </p>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        @forelse ($kategoriTrending as $kategori)
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <p style="font-size: 14px; font-weight: 700; color: #334155; margin: 0;">
                                            {{ $kategori->kategori }}
                                        </p>
                                        <p style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                            Destinasi tersedia
                                        </p>
                                    </div>

                                    <h4 style="font-size: 22px; font-weight: 800; color: #0f172a; margin: 0;">
                                        {{ $kategori->total }}
                                    </h4>
                                </div>
                            </div>
                        @empty
                            <p style="color: #64748b; margin: 0;">Belum ada data kategori.</p>
                        @endforelse
                    </div>
                </div>

            </div>

            <!-- Bottom Section -->
            <div style="display: grid; grid-template-columns: 1.2fr 1fr 1fr; gap: 24px;">

                <!-- AI Recommended for You -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px;">
                        <div>
                            <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                                AI Recommended for You
                            </h3>
                            <p style="font-size: 14px; color: #64748b; margin-top: 4px;">
                                Destinasi unggulan berdasarkan rating tertinggi dalam sistem.
                            </p>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        @forelse ($aiRecommendations as $destinasi)
                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 16px;">
                                <div style="display: flex; justify-content: space-between; gap: 14px;">
                                    <div>
                                        <h4 style="font-size: 16px; font-weight: 800; color: #0f172a; margin: 0;">
                                            {{ $destinasi->nama_wisata }}
                                        </h4>

                                        <p style="font-size: 13px; color: #64748b; margin-top: 5px;">
                                            {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                                        </p>

                                        <p style="font-size: 13px; color: #475569; margin-top: 5px;">
                                            {{ $destinasi->kategori }} • Rating {{ $destinasi->rating }}
                                        </p>
                                    </div>

                                    <div style="font-size: 12px; font-weight: 800; color: #2563eb; background: #dbeafe; height: fit-content; padding: 6px 10px; border-radius: 999px;">
                                        AI Pick
                                    </div>
                                </div>

                                <a href="{{ route('destinasi.show', $destinasi->id) }}"
                                style="background-color: #2563eb; color: white; padding: 8px 12px; border-radius: 10px; font-weight: 700; display: inline-block; text-decoration: none; margin-top: 14px; font-size: 13px;">
                                    Lihat Detail
                                </a>
                            </div>
                        @empty
                            <p style="color: #64748b; margin: 0;">Belum ada rekomendasi destinasi.</p>
                        @endforelse
                    </div>
                </div>

                <!-- Recently Viewed -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 18px; padding: 24px;">
                    <div style="margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                            Latest Destination
                        </h3>
                        <p style="font-size: 14px; color: #64748b; margin-top: 4px;">
                            Destinasi terbaru dalam sistem.
                        </p>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 14px;">
                        @forelse ($recentDestinasi as $destinasi)
                            <a href="{{ route('destinasi.show', $destinasi->id) }}"
                            style="display: block; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px; text-decoration: none;">
                                <p style="font-size: 14px; font-weight: 800; color: #0f172a; margin: 0;">
                                    {{ $destinasi->nama_wisata }}
                                </p>

                                <p style="font-size: 12px; color: #64748b; margin-top: 5px;">
                                    {{ $destinasi->kota }}, {{ $destinasi->provinsi }}
                                </p>

                                <p style="font-size: 12px; color: #f59e0b; margin-top: 5px;">
                                    Rating {{ $destinasi->rating }}
                                </p>
                            </a>
                        @empty
                            <p style="color: #64748b; margin: 0;">Belum ada destinasi terbaru.</p>
                        @endforelse
                    </div>
                </div>

                <!-- AI Assistant Shortcut -->
                <div style="background: linear-gradient(135deg, #2563eb, #0f766e); border-radius: 18px; padding: 24px; color: white;">
                    <h3 style="font-size: 20px; font-weight: 800; margin: 0 0 10px;">
                        AI Travel Assistant
                    </h3>

                    <p style="font-size: 14px; line-height: 1.7; opacity: 0.95; margin-bottom: 24px;">
                        Tanyakan rekomendasi wisata berdasarkan kategori, provinsi, atau budget perjalananmu.
                    </p>

                    <a href="{{ route('ai-assistant.index') }}"
                       style="background: white; color: #1d4ed8; padding: 10px 16px; border-radius: 12px; font-weight: 800; text-decoration: none; display: inline-block;">
                        Ask AI Assistant
                    </a>
                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const activityLabels = @json($activityLabels);
        const activityData = @json($activityData);

        const ctx = document.getElementById('travelActivityChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: activityLabels,
                    datasets: [{
                        label: 'Saved Plans',
                        data: activityData,
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>