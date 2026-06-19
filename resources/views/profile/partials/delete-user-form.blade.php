<section>
    <header style="margin-bottom: 24px;">
        <h2 style="font-size: 20px; font-weight: 900; color: #0f172a; margin: 0 0 6px;">
            Delete Account
        </h2>

        <p style="font-size: 15px; color: #64748b; margin: 0; line-height: 1.6;">
            Permanently delete your Travel Insight AI account and all related account information.
        </p>
    </header>

    <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 18px; padding: 18px; margin-bottom: 22px;">
        <h3 style="font-size: 15px; font-weight: 900; color: #991b1b; margin: 0 0 8px;">
            Warning: This action cannot be undone
        </h3>

        <p style="font-size: 14px; color: #7f1d1d; line-height: 1.6; margin: 0;">
            Once your account is deleted, all account data will be permanently removed. Before deleting your account, make sure you no longer need access to your saved travel plans.
        </p>
    </div>

    <form method="post"
          action="{{ route('profile.destroy') }}"
          onsubmit="return confirm('Are you sure you want to delete this account permanently?')">
        @csrf
        @method('delete')

        <div style="display: flex; flex-direction: column; gap: 18px;">
            <div>
                <label for="password"
                       style="display: block; font-size: 13px; color: #334155; font-weight: 800; margin-bottom: 8px;">
                    Confirm Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    placeholder="Enter your current password"
                    style="width: 100%; border: 1px solid #fecaca; background: #fff7f7; border-radius: 14px; padding: 12px 16px; font-size: 14px; color: #0f172a; outline: none;"
                >

                @if ($errors->userDeletion->get('password'))
                    <p style="font-size: 12px; color: #dc2626; margin: 6px 0 0;">
                        {{ $errors->userDeletion->first('password') }}
                    </p>
                @endif
            </div>

            <div style="border-top: 1px solid #e2e8f0; padding-top: 18px; display: flex; align-items: center; justify-content: space-between; gap: 14px; flex-wrap: wrap;">
                <p style="font-size: 13px; color: #64748b; margin: 0; line-height: 1.5;">
                    Type your current password, then click the button to delete your account.
                </p>

                <button
                    type="submit"
                    style="background: #dc2626; color: white; border: none; padding: 12px 18px; border-radius: 12px; font-size: 14px; font-weight: 900; cursor: pointer;">
                    Delete Account
                </button>
            </div>
        </div>
    </form>
</section>