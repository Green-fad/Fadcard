<div>
    <div class="justify-content-center d-flex">
        <a title="{{ __('messages.vcard.clone_to') }}" data-id="{{ $row->id }}"
            class="btn btn-primary whatsapp-store-clone py-1 px-2">
            {{ __('messages.vcard.clone_to') }}
        </a>
    </div>
    @include('sadmin.whatsapp_stores.whatsapp-store-clone-modal')
</div>
