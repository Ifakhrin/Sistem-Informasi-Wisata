<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                AI Travel Assistant
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Powered by artificial intelligence for Indonesian travel recommendations
            </p>
        </div>
    </x-slot>

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="display: grid; grid-template-columns: 1.6fr 1fr; gap: 28px; align-items: start;">

                <!-- Main Chat Card -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; overflow: hidden;">

                    <!-- Chat Header -->
                    <div style="padding: 24px 28px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                        <div style="display: flex; align-items: center; gap: 14px;">
                            <div style="width: 46px; height: 46px; border-radius: 999px; background: linear-gradient(135deg, #2563eb, #06b6d4); display: flex; align-items: center; justify-content: center; color: white; font-size: 22px;">
                                ✨
                            </div>

                            <div>
                                <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0;">
                                    AI Travel Assistant
                                </h3>
                                <p style="font-size: 14px; color: #64748b; margin-top: 2px;">
                                    Tanyakan destinasi berdasarkan kategori, provinsi, atau budget
                                </p>
                            </div>
                        </div>

                        <div style="background: #dcfce7; color: #059669; padding: 6px 12px; border-radius: 999px; font-size: 13px; font-weight: 700;">
                            ● Active
                        </div>
                    </div>

                    <!-- Chat Box -->
                    <div id="chat-box" style="height: 520px; overflow-y: auto; padding: 28px; background: #ffffff;">
                        <div style="display: flex; margin-bottom: 16px;">
                            <div style="width: 34px; height: 34px; border-radius: 999px; background: #0ea5e9; color: white; display: flex; align-items: center; justify-content: center; margin-right: 12px; flex-shrink: 0;">
                                ✨
                            </div>

                            <div style="background: #e5e7eb; color: #111827; padding: 14px 18px; border-radius: 16px; max-width: 75%; line-height: 1.6;">
                                Halo! Saya bisa membantu memberikan rekomendasi destinasi wisata di Indonesia berdasarkan data yang tersedia dalam sistem.
                            </div>
                        </div>
                    </div>

                    <!-- Input Area -->
                    <div style="padding: 18px 24px 24px; border-top: 1px solid #e2e8f0; background: #ffffff;">
                        <form id="chat-form" style="display: flex; gap: 12px; align-items: center;">
                            @csrf

                            <input
                                type="text"
                                id="message"
                                name="message"
                                style="flex: 1; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 999px; padding: 13px 18px; font-size: 14px; outline: none;"
                                placeholder="Contoh: rekomendasikan wisata alam di Bali budget 50000"
                                autocomplete="off"
                            >

                            <button
                                type="submit"
                                style="width: 48px; height: 48px; border-radius: 999px; background: #2563eb; color: white; border: none; font-size: 18px; font-weight: 800; cursor: pointer;">
                                ➤
                            </button>
                        </form>

                        <div style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 14px;">
                            <button type="button" style="border: 1px solid #e2e8f0; background: white; color: #334155; border-radius: 999px; padding: 8px 12px; font-size: 13px;">
                                📍 Wisata budaya di Jawa
                            </button>

                            <button type="button" style="border: 1px solid #e2e8f0; background: white; color: #334155; border-radius: 999px; padding: 8px 12px; font-size: 13px;">
                                💰 Wisata murah untuk keluarga
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div style="display: flex; flex-direction: column; gap: 24px;">

                    <!-- Travel Planning Panel -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 22px;">
                            Travel Planning Panel
                        </h3>

                        <div style="margin-bottom: 18px;">
                            <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
                                <span>Budget</span>
                                <strong style="color: #0f172a;">Flexible</strong>
                            </div>
                            <div style="height: 8px; background: #e2e8f0; border-radius: 999px;">
                                <div style="height: 8px; width: 58%; background: linear-gradient(90deg, #2563eb, #06b6d4); border-radius: 999px;"></div>
                            </div>
                        </div>

                        <div style="border-top: 1px solid #e2e8f0; padding-top: 18px; display: flex; flex-direction: column; gap: 16px;">
                            <div>
                                <p style="font-size: 13px; color: #64748b; margin: 0;">Duration</p>
                                <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 4px 0 0;">Custom trip</p>
                            </div>

                            <div>
                                <p style="font-size: 13px; color: #64748b; margin: 0;">Travelers</p>
                                <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 4px 0 0;">Personalized</p>
                            </div>

                            <div>
                                <p style="font-size: 13px; color: #64748b; margin: 0;">Departure</p>
                                <p style="font-size: 15px; font-weight: 700; color: #0f172a; margin: 4px 0 0;">Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <!-- Suggested Prompts -->
                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 22px; padding: 24px;">
                        <h3 style="font-size: 18px; font-weight: 800; color: #0f172a; margin: 0 0 20px;">
                            Suggested Prompts
                        </h3>

                        <div style="display: flex; flex-direction: column; gap: 14px;">
                            <div style="display: flex; align-items: center; gap: 12px; color: #334155; font-size: 14px;">
                                <span style="width: 34px; height: 34px; border-radius: 999px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">📍</span>
                                Rekomendasi wisata di Jawa
                            </div>

                            <div style="display: flex; align-items: center; gap: 12px; color: #334155; font-size: 14px;">
                                <span style="width: 34px; height: 34px; border-radius: 999px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">💰</span>
                                Tempat wisata murah untuk keluarga
                            </div>

                            <div style="display: flex; align-items: center; gap: 12px; color: #334155; font-size: 14px;">
                                <span style="width: 34px; height: 34px; border-radius: 999px; background: #dbeafe; color: #2563eb; display: flex; align-items: center; justify-content: center;">◎</span>
                                Destinasi petualangan untuk solo traveler
                            </div>
                        </div>
                    </div>

                    <!-- AI Tip -->
                    <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 22px; padding: 24px;">
                        <h3 style="font-size: 17px; font-weight: 800; color: #0f172a; margin: 0 0 10px;">
                            AI Tip
                        </h3>
                        <p style="font-size: 14px; color: #64748b; line-height: 1.7; margin: 0;">
                            Tulis preferensi secara spesifik, misalnya kategori wisata, provinsi, dan budget agar rekomendasi lebih sesuai.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div> 

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('chat-form');
            const input = document.getElementById('message');
            const chatBox = document.getElementById('chat-box');

            function cleanText(text) {
                return text
                    .replace(/\*\*/g, '')
                    .replace(/Berikut beberapa rekomendasi destinasi wisata alam di Indonesia untuk budget murah:\s*/i, 'Berikut rekomendasi destinasi wisata alam dengan budget murah:\n\n')
                    .replace(/Berikut adalah beberapa rekomendasi destinasi wisata alam di Indonesia yang cocok untuk budget murah:\s*/i, 'Berikut rekomendasi destinasi wisata alam dengan budget murah:\n\n')
                    .replace(/(^|\n)(\d+)\.\s*/g, '$1\n\n$2. ')
                    .replace(/\s*-\s*Lokasi:/gi, '\nLokasi:')
                    .replace(/\s*-\s*Alasan cocok:/gi, '\nAlasan cocok:')
                    .replace(/\s*-\s*Estimasi budget:/gi, '\nEstimasi budget:')
                    .replace(/\s*-\s*Aktivitas:/gi, '\nAktivitas:')
                    .replace(/\s+Lokasi:/gi, '\nLokasi:')
                    .replace(/\s+Alasan cocok:/gi, '\nAlasan cocok:')
                    .replace(/\s+Estimasi budget:/gi, '\nEstimasi budget:')
                    .replace(/\s+Aktivitas:/gi, '\nAktivitas:')
                    .replace(/\n{3,}/g, '\n\n')
                    .trim();
            }

            function addMessage(text, sender) {

                const wrapper = document.createElement('div');

                wrapper.style.display = 'flex';
                wrapper.style.marginBottom = '16px';

                const bubble = document.createElement('div');

                bubble.style.padding = '12px 16px';
                bubble.style.borderRadius = '12px';
                bubble.style.maxWidth = '75%';
                bubble.style.whiteSpace = 'pre-line';
                bubble.style.lineHeight = '1.6';

                if (sender === 'user') {

                    wrapper.style.justifyContent = 'flex-end';

                        bubble.style.backgroundColor = '#2563eb';
                        bubble.style.color = '#ffffff';

                    } else {

                        wrapper.style.justifyContent = 'flex-start';

                        bubble.style.backgroundColor = '#e5e7eb';
                        bubble.style.color = '#111827';

                    }

                    bubble.textContent = sender === 'ai'
                        ? cleanText(text)
                        : text;

                    wrapper.appendChild(bubble);
                    chatBox.appendChild(wrapper);

                    chatBox.scrollTop = chatBox.scrollHeight;
            }

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                const message = input.value.trim();

                if (!message) {
                    return;
                }

                addMessage(message, 'user');
                input.value = '';

                addMessage('AI sedang memproses jawaban...', 'ai');

                try {
                    const response = await fetch("{{ route('ai-assistant.ask') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            message: message
                        })
                    });

                    const data = await response.json();

                    chatBox.lastChild.remove();

                    if (!response.ok) {
                        addMessage(data.message || 'Terjadi kesalahan saat menghubungi AI.', 'ai');
                        return;
                    }

                    addMessage(data.answer, 'ai');
                } catch (error) {
                    chatBox.lastChild.remove();
                    addMessage('Koneksi ke AI Assistant gagal. Periksa koneksi internet atau konfigurasi API.', 'ai');
                }
            });
        });
    </script>

</x-app-layout>