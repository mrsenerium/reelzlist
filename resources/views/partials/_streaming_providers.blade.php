@if (isset($providers))
    <div>
        <div>{{ $title }}</div>
        <div class="d-flex">
            @foreach ($providers as $provider)
                <div class="card-text provider-card">
                    <img src="https://www.themoviedb.org/t/p/original{{ $provider->logo_path }}"
                        alt="{{ $provider->provider_name }}"
                        class="provider-logo"
                        width="50"
                        height="50"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="{{ $provider->provider_name }}"
                        />
                </div>
            @endforeach
        </div>
    </div>
@endif
