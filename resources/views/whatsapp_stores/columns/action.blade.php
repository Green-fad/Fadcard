<div class="justify-content-center d-flex">
    <a href="{{ route('whatsapp.stores.edit', ['whatsappStore' => $row->id, 'part' => 'basics']) }}" class="btn px-1 text-primary  fs-3" 
        title="{{ __('messages.common.edit') }}">
        <i class="fa-solid fa-pen-to-square"></i>
    </a>

    <a href="javascript:void(0)" title="<?php echo __('messages.common.delete'); ?>" data-id="{{ $row->id }}"
        class="whatsapp-store-delete-btn btn px-1 text-danger fs-3" data-turbo="false">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
