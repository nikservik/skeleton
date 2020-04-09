        <div class="user-card hover:bg-indigo-100">
            @if($user->hasVerifiedEmail())
                <div class="status-square bg-indigo-400">
                    <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path class="heroicon-ui" d="M4 4h16a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2zm16 3.38V6H4v1.38l8 4 8-4zm0 2.24l-7.55 3.77a1 1 0 0 1-.9 0L4 9.62V18h16V9.62z"/></svg>
                </div>
            @else
                <div class="status-square bg-indigo-300">
                    <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20"><path class="heroicon-ui" d="M18.59 13H3a1 1 0 0 1 0-2h15.59l-5.3-5.3a1 1 0 1 1 1.42-1.4l7 7a1 1 0 0 1 0 1.4l-7 7a1 1 0 0 1-1.42-1.4l5.3-5.3z"/></svg>
                </div>
            @endif
            <div class="">
                <a href="/users/{{ $user->id }}">{{ $user->name }}</a>
                <span class="text-sm ml-2">{{ $user->email }}</span>
                <div>
                    <span class="text-sm text-gray-500">
                        @lang('admin/users.registered') {{ $user->created_at->format('d.m.Y') }}
                    </span>
                </div>
            </div>
            <div class="ml-auto">
            <a href="/users/{{ $user->id }}/delete" onclick="return confirm('@lang('admin/users.confirmDelete')')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" class="inline-block fill-current text-gray-500"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg></a>
            </div>
        </div>
