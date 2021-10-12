<div class="nav-tabs-custom">
    <center>
        <ul class="nav nav-tabs">
            <li class="tab-default active"><a href="#schedaen" data-toggle="tab">Scheda</a></li>
            <li class="tab-default"><a href="#CUTFen" data-toggle="tab">Immagini</a></li>
            @if(Route::current()->getName() != 'admin.products.edit')
            <li class="tab-default"><a href="#CPCen" data-toggle="tab">Offerte </a></li>
           @endif
        </ul>
    </center>
    <div class="tab-content">
        <div class="tab-pane active" id="schedaen">
            <!------------------------------------------------------->
        <?php $lang = 'en' ?>
        @include('admin.products.partials._generalinput')
        <!------------------------------------------------------->
        </div>
        <div class="tab-pane" id="CUTFen">
            @include('admin.products.partials._cutf')
        </div>
        @if(Route::current()->getName() != 'admin.products.edit')
        <div class="tab-pane" id="CPCen">
            @include('admin.products.partials._cpc')
        </div>
            @endif

    </div>
</div>


