<section>
    <header style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
            Account Information
        </h2>

        <p style="font-size: 15px; color: #64748b; margin: 0;">
            Update your personal details, account email, and profile photo.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="delete-profile-photo" method="post" action="{{ route('profile.photo.destroy') }}">
        @csrf
        @method('delete')
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Profile Photo --}}
        <div style="margin-bottom: 24px;">
            <label style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 10px;">
                Profile Photo
            </label>

            <div style="display: flex; align-items: center; gap: 18px; flex-wrap: wrap;">
                <div>
                    @if ($user->profile_photo)
                        <img
                            id="profilePhotoPreview"
                            src="{{ asset('storage/' . $user->profile_photo) }}"
                            alt="Profile Photo"
                            style="width: 86px; height: 86px; border-radius: 50%; object-fit: cover; border: 3px solid #ffffff; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);"
                        >

                        <div
                            id="profilePhotoFallback"
                            style="display: none; width: 86px; height: 86px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #06b6d4); color: white; align-items: center; justify-content: center; font-size: 28px; font-weight: 900; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);"
                        >
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    @else
                        <img
                            id="profilePhotoPreview"
                            src=""
                            alt="Profile Photo"
                            style="display: none; width: 86px; height: 86px; border-radius: 50%; object-fit: cover; border: 3px solid #ffffff; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);"
                        >

                        <div
                            id="profilePhotoFallback"
                            style="display: flex; width: 86px; height: 86px; border-radius: 50%; background: linear-gradient(135deg, #2563eb, #06b6d4); color: white; align-items: center; justify-content: center; font-size: 28px; font-weight: 900; box-shadow: 0 12px 28px rgba(15, 23, 42, 0.16);"
                        >
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                </div>

                <div>
                    <input
                        id="profile_photo"
                        name="profile_photo"
                        type="file"
                        accept="image/*"
                        onchange="previewProfilePhoto(event)"
                        style="display: none;"
                    >

                    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                        <label
                            for="profile_photo"
                            style="display: inline-flex; align-items: center; justify-content: center; background: #2563eb; color: white; border: none; padding: 11px 16px; border-radius: 12px; font-size: 14px; font-weight: 900; cursor: pointer; box-shadow: 0 12px 24px rgba(37, 99, 235, 0.18);"
                        >
                            Ganti Foto
                        </label>

                        @if ($user->profile_photo)
                            <button
                                type="submit"
                                form="delete-profile-photo"
                                onclick="return confirm('Yakin ingin menghapus foto profil?')"
                                style="display: inline-flex; align-items: center; justify-content: center; background: #ffffff; color: #dc2626; border: 1px solid #fecaca; padding: 10px 16px; border-radius: 12px; font-size: 14px; font-weight: 900; cursor: pointer;"
                            >
                                Hapus Foto
                            </button>
                        @endif
                    </div>

                    <p style="font-size: 12px; color: #94a3b8; margin: 8px 0 0;">
                        Format: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </p>

                    @if ($errors->get('profile_photo'))
                        <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                            {{ $errors->first('profile_photo') }}
                        </p>
                    @endif

                    @if (session('status') === 'profile-photo-deleted')
                        <p style="font-size: 12px; color: #166534; margin: 6px 0 0; font-weight: 800;">
                            Foto profil berhasil dihapus.
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px;">
            <div>
                <label for="name" style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                    Full Name
                </label>

                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name', $user->name) }}"
                    required
                    autofocus
                    autocomplete="name"
                    style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
                >

                @if ($errors->get('name'))
                    <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                        {{ $errors->first('name') }}
                    </p>
                @endif
            </div>

            <div>
                <label style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                    Account Level
                </label>

                <input
                    type="text"
                    value="{{ $user->role === 'admin' ? 'Administrator' : 'Traveler' }}"
                    disabled
                    style="width: 100%; border: 1px solid #e2e8f0; background: #f8fafc; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #64748b; outline: none;"
                >
            </div>
        </div>

        <div style="margin-bottom: 18px;">
            <label for="email" style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                Email Address
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email', $user->email) }}"
                required
                autocomplete="username"
                style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
            >

            @if ($errors->get('email'))
                <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                    {{ $errors->first('email') }}
                </p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div style="margin-top: 12px; background: #fff7ed; border: 1px solid #fed7aa; color: #9a3412; padding: 12px 14px; border-radius: 14px; font-size: 13px;">
                    Your email address is unverified.

                    <button
                        form="send-verification"
                        style="border: none; background: transparent; color: #2563eb; font-weight: 800; cursor: pointer; padding: 0; margin-left: 4px;">
                        Re-send verification email.
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin: 8px 0 0; color: #166534; font-weight: 700;">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="margin-bottom: 22px;">
            <label for="bio" style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                Bio
            </label>

            <textarea
                id="bio"
                name="bio"
                rows="4"
                maxlength="500"
                placeholder="Tell us about your travel style..."
                style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none; resize: vertical;">{{ old('bio', $user->bio) }}</textarea>

            @if ($errors->get('bio'))
                <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                    {{ $errors->first('bio') }}
                </p>
            @else
                <p style="font-size: 12px; color: #94a3b8; margin: 6px 0 0;">
                    Maximum 500 characters.
                </p>
            @endif
        </div>

        <div style="border-top: 1px solid #e2e8f0; padding-top: 18px; display: flex; align-items: center; gap: 12px;">
            <button
                type="submit"
                style="background: #2563eb; color: white; border: none; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 900; cursor: pointer;">
                Save Changes
            </button>

            <a href="{{ route('profile.edit') }}"
               style="background: white; color: #334155; border: 1px solid #e2e8f0; padding: 11px 18px; border-radius: 12px; font-size: 14px; font-weight: 800; text-decoration: none;">
                Cancel
            </a>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 14px; color: #166534; font-weight: 800; margin: 0;">
                    Saved.
                </p>
            @endif
        </div>
    </form>

    <script>
        function previewProfilePhoto(event) {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            const preview = document.getElementById('profilePhotoPreview');
            const fallback = document.getElementById('profilePhotoFallback');

            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';

            if (fallback) {
                fallback.style.display = 'none';
            }
        }
    </script>
</section>