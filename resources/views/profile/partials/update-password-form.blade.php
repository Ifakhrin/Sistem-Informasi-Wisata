<section>
    <header style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
            Security Settings
        </h2>

        <p style="font-size: 15px; color: #64748b; margin: 0;">
            Update your password to keep your Travel Insight AI account secure.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div style="display: flex; flex-direction: column; gap: 18px;">

            <div>
                <label for="update_password_current_password"
                       style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                    Current Password
                </label>

                <input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    autocomplete="current-password"
                    style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
                >

                @if ($errors->updatePassword->get('current_password'))
                    <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                        {{ $errors->updatePassword->first('current_password') }}
                    </p>
                @endif
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 18px;">
                <div>
                    <label for="update_password_password"
                           style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                        New Password
                    </label>

                    <input
                        id="update_password_password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
                    >

                    @if ($errors->updatePassword->get('password'))
                        <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                            {{ $errors->updatePassword->first('password') }}
                        </p>
                    @endif
                </div>

                <div>
                    <label for="update_password_password_confirmation"
                           style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                        Confirm Password
                    </label>

                    <input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        style="width: 100%; border: 1px solid #e2e8f0; background: #f1f5f9; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
                    >

                    @if ($errors->updatePassword->get('password_confirmation'))
                        <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                            {{ $errors->updatePassword->first('password_confirmation') }}
                        </p>
                    @endif
                </div>
            </div>

            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 16px; padding: 14px 16px;">
                <p style="font-size: 13px; color: #1e3a8a; line-height: 1.6; margin: 0;">
                    Use a secure password with at least 8 characters. Combine uppercase letters, lowercase letters, numbers, and symbols if possible.
                </p>
            </div>

            <div style="border-top: 1px solid #e2e8f0; padding-top: 18px; display: flex; align-items: center; gap: 12px;">
                <button
                    type="submit"
                    style="background: #2563eb; color: white; border: none; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 900; cursor: pointer;">
                    Update Password
                </button>

                @if (session('status') === 'password-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        style="font-size: 14px; color: #166534; font-weight: 800; margin: 0;">
                        Password updated.
                    </p>
                @endif
            </div>

        </div>
    </form>
</section>