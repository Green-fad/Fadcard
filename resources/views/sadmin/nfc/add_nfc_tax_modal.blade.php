<div class="modal fade" id="addNfcTaxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">{{ __('messages.nfc.add_tax') }}</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            {{ Form::open(['id'=>'addNfcTaxForm']) }}
            <div class="modal-body">
                <div class="alert alert-danger fs-4 text-white d-flex align-items-center  d-none" role="alert" id="NfcValidationErrorsBox">
                    <i class="fa-solid fa-face-frown me-5"></i>
                </div>
                <div class="mb-5">
                    {{ Form::label('nfc_tax_value',__('Tax').':', ['class' => 'form-label required']) }}
                    {{ Form::number('nfc_tax_value', null, ['class' => 'form-control', 'required','placeholder' => __('messages.nfc.tax'),'id' => 'nfcCardTax','autofocus']) }}
                </div>
            <div>
                <h6>{{ __('messages.nfc.note_tax_will_be_percentage') }}</h6>
            </div>

            <div class="form-check form-switch mt-3">
                <input class="form-check-input" type="checkbox" id="nfcTaxStatus" name="nfc_tax_enabled" value="1">
                <label class="form-check-label" for="nfcTaxStatus">{{ __('messages.nfc.enable_tax') }}</label>
            </div>

            </div>
            <div class="modal-footer pt-0">
                {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary m-0','id'=>'btnSave']) }}
                <button type="button" class="btn btn-secondary my-0 ms-5 me-0"
                        data-bs-dismiss="modal">{{ __('messages.common.discard') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
