<div class="row">
    <center><h5>Anagrafica Macchina</h5></center>

    <div class="row">
        <div class="col-lg-2">
            <label for="partita" class="control-label">Partita *</label>
            <input type="text" name="partita" id="partita" value="{{ $product->partita }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="family" class="control-label">Famiglia *</label>
            <input type="text" name="family" id="family" value="{{ $product->family }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="type" class="control-label">Tipologia *</label>
            <input type="text" name="type" id="type" value="{{ $product->type }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="category" class="control-label">Categoria *</label>
            <input type="text" name="category" id="category" value="{{ $product->category }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="class" class="control-label">Class *</label>
            <input type="text" name="class" id="class" value="{{ $product->class }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="subclass" class="control-label">Subclass *</label>
            <input type="text" name="subclass" id="subclass" value="{{ $product->subclass }}" class="form-control" required readonly>
        </div>
    </div>
    <BR><BR>
    <div class="row">
        <div class="col-lg-2">
            <label for="brand" class="control-label">Marca *</label>
            <input type="text" name="brand" id="brand" value="{{ $product->brand }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="model" class="control-label">Modello *</label>
            <input type="text" name="model" id="model" value="{{ $product->model }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="serialnum" class="control-label">N. seriale *</label>
            <input type="text" name="serialnum" id="serialnum" value="{{ $product->serialnum }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="year" class="control-label">Anno *</label>
            <input type="text" name="year" id="year" value="{{ $product->year }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="orelavoro" class="control-label">Ore lavoro *</label>
            <input type="text" name="orelavoro" id="orelavoro" value="{{ $product->orelavoro }}" class="form-control" required readonly>
        </div>
    </div>
    <BR><BR>
    <div class="row">
        <div class="col-lg-3">
            <label for="macchinallestita" class="control-label">Ubicazione *</label>
            <input type="text" name="location" id="location" value="{{ $product->location }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="typeallestimento" class="control-label">Tipo allestimento *</label>
            <input type="text" name="typeallestimento" id="typeallestimento" value="{{ $product->typeallestimento }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="macchinallestita" class="control-label">Macchina allestita *</label>
            <input type="text" name="macchinallestita" id="macchinallestita" value="{{ $product->macchinallestita }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="macchinallestita" class="control-label">Data entrata merce *</label>
            <input type="text" name="macchinallestita" id="macchinallestita" value="{{ $product->data_em }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-3">
            <label for="macchinallestita" class="control-label">Fornitore *</label>
            <input type="text" name="macchinallestita" id="macchinallestita" value="{{ $product->fornitore }}" class="form-control" required readonly>
        </div>
    </div>
    <BR><BR>
    <div class="row">
        <div class="col-lg-2">
            <label for="totalecostoallestimenti" class="control-label">Totale costo allestimenti *</label>
            <input type="text" name="totalecostoallestimenti" id="totalecostoallestimenti" value="{{ $product->totalecostoallestimenti }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="overallowance" class="control-label">Over allowance *</label>
            <input type="text" name="overallowance" id="overallowance" value="{{ $product->overallowance }}" class="form-control" required readonly>
        </div>
        <div class="col-lg-2">
            <label for="pagato_cliente" class="control-label">Pagato Cliente *</label>
            <input type="text" name="pagato_cliente" id="pagato_cliente" value="{{ $product->pagato_cliente }}" class="form-control" required readonly>
        </div>
    </div>












</div>
<div class="row">

    @if($q != NULL)
        <center><h5>Caratteristiche Commerciali</h5></center>
        @if($lang == 'en')
            <form action="{{ route('admin.product.editdataproduct',['id'=> $product->id, 'lang'=>$lang ]) }}" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <h5 style="margin-left: 3%;"><strong>Filtrabile</strong></h5><BR>
            @foreach($q as $line)
                @if($line['filter'] == 'X')
                 @include('admin.products.partials._inputtype_en')
                    @endif
            @endforeach
                </div>
                <div class="row">
                 <hr><BR>
                        <h5 style="margin-left: 3%;"><strong>Non filtrabile</strong></h5><BR>
                @foreach($q as $line)
                    @if($line['filter'] != 'X')
                        @include('admin.products.partials._inputtype_en')
                    @endif
                @endforeach
                </div>
             <div class="col-lg-12" style="margin-top: 5%">
                 @if(Route::current()->getName() != 'admin.products.show')
                     <center>
                         <button class="btn btn-success" type="submit"> Salva</button>
                     </center>
                 @endif
             </div>
            </form>

        @else
            <form action="{{ route('admin.product.editdataproduct',['id'=> $product->id, 'lang'=>$lang ]) }}" method="POST">
                {!! csrf_field() !!}
                <div class="row">
                    <h5 style="margin-left: 3%;"><strong>Filtrabile</strong></h5><BR>
                @foreach($q as $line)
                    @if($line['filter'] == 'X')
                        @include('admin.products.partials._inputtype_it')
                    @endif
                @endforeach
                </div>
           <hr><BR>
                <div class="row">
                    <h5 style="margin-left: 3%;"><strong>Non filtrabile</strong></h5><BR>
                @foreach($q as $line)
                    @if($line['filter'] != 'X')
                        @include('admin.products.partials._inputtype_it')
                    @endif
                @endforeach
                </div>
                <div class="col-lg-12" style="margin-top: 5%">
                    @if(Route::current()->getName() != 'admin.products.show')
                    <center>
                        <button class="btn btn-success" type="submit"> Salva</button>
                    </center>
                    @endif
                </div>
            </form>
        @endif
    @endif
</div>
