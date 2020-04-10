        <div class="user-card hover:bg-indigo-100">
            <div class="">
                <a href="/tariffs/{{ $tariff->id }}">{{ $tariff->name }}</a>
                <span class="text-sm ml-2">{{ $tariff->short_name }}</span>
                <div>
                    <span class="text-sm text-gray-500">
                        {{ $tariff->price }} {{ $tariff->currency }}
                        / @lang('admin/tariffs.'.$tariff->periodLocale)
                        @if($tariff->prolongable)
                            / @lang('admin/tariffs.prolongable')
                        @endif
                    </span>
                </div>
            </div>
            <div class="ml-auto">
                <a href="/tariffs/{{ $tariff->id }}/edit">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" class="inline-block fill-current text-gray-500"><path class="heroicon-ui" d="M6.3 12.3l10-10a1 1 0 0 1 1.4 0l4 4a1 1 0 0 1 0 1.4l-10 10a1 1 0 0 1-.7.3H7a1 1 0 0 1-1-1v-4a1 1 0 0 1 .3-.7zM8 16h2.59l9-9L17 4.41l-9 9V16zm10-2a1 1 0 0 1 2 0v6a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6c0-1.1.9-2 2-2h6a1 1 0 0 1 0 2H4v14h14v-6z"/></svg></a>
            </div>
            <div class="ml-1">
                <form name="tariff_{{ $tariff->id }}_delete" action="/tariffs/{{ $tariff->id }}" method="POST">
                    @csrf 
                    @method('DELETE')
                </form>
                <a href="javascript:document.tariff_{{ $tariff->id }}_delete.submit()" onclick="return confirm('@lang('admin/tariffs.confirmDelete')')">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" class="inline-block fill-current text-gray-500"><path class="heroicon-ui" d="M8 6V4c0-1.1.9-2 2-2h4a2 2 0 0 1 2 2v2h5a1 1 0 0 1 0 2h-1v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8H3a1 1 0 1 1 0-2h5zM6 8v12h12V8H6zm8-2V4h-4v2h4zm-4 4a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1zm4 0a1 1 0 0 1 1 1v6a1 1 0 0 1-2 0v-6a1 1 0 0 1 1-1z"/></svg></a>
            </div>
        </div>
