<div class="btn btn-default btn-file">
    <i class="fa fa-paperclip"></i> {{ $label }}
    <input 
        @if(isset($disabled)) disabled @endif
        type="file" 
        name="{{ $name }}" 
        class="btn file-upload" 
        @if($multiple) multiple="multiple" @endif 
        data-preview-container="{{ $previewContainer }}">
</div>