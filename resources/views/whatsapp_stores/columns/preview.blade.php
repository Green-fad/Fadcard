<a class="fs-6 text-decoration-none mt-1 text-primary" href="{{ route('whatsapp.store.show', $row->url_alias) }}"
    target="_blank">
    {{ url(route('whatsapp.store.show', $row->url_alias)) }}
    <span style="
        display:inline-block;
        width:16px;
        height:16px;
        background-color: currentColor;
        mask: url('{{ asset('images/new-tab.svg') }}') no-repeat center;
        mask-size: cover;
        vertical-align: middle;">
    </span>
</a>