<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0;">
                Profile Settings
            </h2>
            <p style="font-size: 15px; color: #64748b; margin-top: 6px;">
                Manage your account, preferences, and travel profile
            </p>
        </div>
    </x-slot>

    @php
        $nameParts = explode(' ', trim($user->name));
        $initials = strtoupper(substr($nameParts[0] ?? 'U', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
        $initials = $initials ?: 'U';
    @endphp

    <div style="background: #f8fafc; min-height: 100vh; padding: 32px 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div style="display: grid; grid-template-columns: 0.85fr 1.65fr; gap: 28px; align-items: start;">

                <!-- Left Profile Card -->
                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 32px; text-align: center;">

                    @if ($user->profile_photo)
                        <img
                            src="{{ asset('storage/' . $user->profile_photo) }}"
                            alt="Profile Photo"
                            style="
                                width: 112px;
                                height: 112px;
                                border-radius: 999px;
                                object-fit: cover;
                                border: 4px solid #ffffff;
                                margin: 0 auto 18px;
                                display: block;
                                box-shadow: 0 10px 24px rgba(37, 99, 235, 0.25);
                            "
                        >
                    @else
                        <div style="
                            width: 112px;
                            height: 112px;
                            border-radius: 999px;
                            background: linear-gradient(135deg, #2563eb, #06b6d4);
                            color: white;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            font-size: 34px;
                            font-weight: 800;
                            margin: 0 auto 18px;
                            box-shadow: 0 10px 24px rgba(37, 99, 235, 0.25);
                        ">
                            {{ $initials }}
                        </div>
                    @endif

                    <h3 style="font-size: 22px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
                        {{ $user->name }}
                    </h3>

                    <p style="font-size: 14px; color: #64748b; margin: 0 0 12px;">
                        {{ $user->email }}
                    </p>

                    <span style="display: inline-block; background: linear-gradient(135deg, #2563eb, #06b6d4); color: white; padding: 7px 13px; border-radius: 999px; font-size: 12px; font-weight: 800; margin-bottom: 28px;">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Traveler' }}
                    </span>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-top: 10px;">

                        <div style="background: #e2e8f0; border-radius: 18px; padding: 20px 14px;">
                            <div style="font-size: 22px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">
                                {{ $totalDestinations }}
                            </div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                                Total<br>Destinations
                            </div>
                        </div>

                        <div style="background: #e2e8f0; border-radius: 18px; padding: 20px 14px;">
                            <div style="font-size: 22px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">
                                {{ $savedPlacesCount }}
                            </div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                                Saved<br>Places
                            </div>
                        </div>

                        <div style="background: #e2e8f0; border-radius: 18px; padding: 20px 14px;">
                            <div style="font-size: 22px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">
                                {{ $travelScore }}
                            </div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                                Travel<br>Score
                            </div>
                        </div>

                        <div style="background: #e2e8f0; border-radius: 18px; padding: 20px 14px;">
                            <div style="font-size: 22px; font-weight: 900; color: #0f172a; margin-bottom: 4px;">
                                {{ $user->created_at ? $user->created_at->format('Y') : '-' }}
                            </div>
                            <div style="font-size: 12px; color: #64748b; line-height: 1.4;">
                                Member<br>Since
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Settings Area -->
                <div style="display: flex; flex-direction: column; gap: 24px;">

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px;">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div style="background: white; border: 1px solid #e2e8f0; border-radius: 24px; padding: 28px;">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div style="background: white; border: 1px solid #fecaca; border-radius: 24px; padding: 28px;">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>