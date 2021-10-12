<div class="nav-tabs-custom">
    <center>
    <ul class="nav nav-tabs">
        <li class="tab-default active"><a href="#schedait" data-toggle="tab">Scheda</a></li>
        <li class="tab-default"><a href="#CUTF" data-toggle="tab">Immagini</a></li>
        @if(Route::current()->getName() != 'admin.products.edit')
        <li class="tab-default"><a href="#CPC" data-toggle="tab">Offerte </a></li>
        @endif
    </ul>
    </center>
    <div class="tab-content">
        <div class="tab-pane active" id="schedait">
            <!------------------------------------------------------->
            <?php $lang = 'it' ?>
        @include('admin.products.partials._generalinput')
            <!------------------------------------------------------->
        </div>
        <div class="tab-pane" id="CUTF">
            @include('admin.products.partials._cutf')
        </div>
        @if(Route::current()->getName() != 'admin.products.edit')
        <div class="tab-pane" id="CPC">
            @include('admin.products.partials._cpc')
        </div>
            @endif

    </div>
</div>
