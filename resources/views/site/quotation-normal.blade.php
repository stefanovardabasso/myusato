<!DOCTYPE html>
<html lang="en">

@include('site.partiales._pagehead')

<body>

<!-- Header -->

@include('site.partiales._header')





<div class="container px-15 md_px-0" style="margin-bottom: 10%; margin-top: 5%">
    <div class="text-center"><h2>{{__(' Richiesta di quotazione')}}</h2></div>

    <div class="new-ads mb-30">
        <div style="margin-top: 5%; margin-bottom: 5%">
            <div class="text-center">{{$title}}</div>
            <div class="text-center">{{$text}}</div>

          <div class="row-15 flex flex-wrap mb-40 mt-40">
            @foreach($lines as $line)
                @if($offerts[$line->id]->type_off == 'single')
                      <div class="lg_col-3 md_col-4 col-12 px-15 mb-40">
                          <div class="ad-box-products">
                              <div class="ad-image">
                                  <div class="ad-tags absolute top-10 left-0 z-10">
                                      <div class="tag-1">
                                          <span>{{$offerts[$line->id]->title}}</span>
                                      </div>
                                  </div>
                                  <!--  <a href="" class="ad-add absolute top-10 right-10 z-10">
                                        <i class="material-icons font-30">add</i>
                                    </a> -->
                                  @if(isset($image))
                                      <img src="https://myusato.cls.it/upload/{{ $image[$offerts[$line->id]->id]->name }}"  alt="">
                                  @endif


                              </div>

                              <div class="ad-titles">
                                  <ul class="text-primary bc-secondary p-15">
                                      <!-- <li class="flex justify-between align-center mb-15">
                                           <span class="weight-400">Tipologia:</span>
                                           <span class="font-18">Fontale elettrico</span>
                                       </li> -->
                                      <li class="flex justify-between align-center mb-15">
                                          <span class="weight-400">Marca:</span>
                                          <span class="font-18">{{ $prods[$offerts[$line->id]->id]->brand }}</span>
                                      </li>
                                      <li class="flex justify-between align-center">
                                          <span class="weight-400">Modello:</span>
                                          <span class="font-18">{{ $prods[$offerts[$line->id]->id]->model }}</span>
                                      </li>
                                  </ul>
                              </div>
                              <div class="ad-info">
                                  <ul>
                                      <li class="flex justify-between mb-12">
                                          <span class="weight-400">Portata:</span>
                                          <span>800</span>
                                      </li>
                                      <li class="flex justify-between mb-12">
                                          <span class="weight-400">Montante:</span>
                                          <span>2 Stadi NO A.I.</span>
                                      </li>
                                      <li class="flex justify-between mb-12">
                                          <span class="weight-400">Sollevamento:</span>
                                          <span>4000</span>
                                      </li>
                                      <li class="flex justify-between mb-12">
                                          <span class="weight-400">Anno:</span>
                                          <span>{{ $prods[$offerts[$line->id]->id]->year }}</span>
                                      </li>
                                      <li class="flex justify-between mb-13">
                                          <span class="weight-400">Allestimento:</span>
                                          <span class="uppercase">Easy</span>
                                      </li>
                                      <li class="flex justify-between mb-13">
                                          <span class="weight-400">Stato alle:</span>
                                          <span class="uppercase">Da preparare</span>
                                      </li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  @else

                      <div class="lg_col-3 md_col-4 col-12 px-15 mb-40">
                          <div class="ad-box-products">
                              <div class="ad-image">
                                  <div class="ad-tags absolute top-10 left-0 z-10">
                                      <div class="tag-1">
                                          <span>{{$offerts[$line->id]->title}} </span>
                                      </div>
                                  </div>
                                  <!--  <a href="" class="ad-add absolute top-10 right-10 z-10">
                                        <i class="material-icons font-30">add</i>
                                    </a> -->
                                  @if(isset($image))
                                      <img src="https://myusato.cls.it/upload/{{ $image[$offerts[$line->id]->id]->name }}"  alt="">
                                  @endif


                              </div>

                              <div class="ad-titles">
                                  <table class="off-table pt-10">
                                      <thead>
                                      <tr class="pt-10">
                                          <th class="p-15">Marca</th>
                                          <th class="p-15">Modello</th>
                                      </tr>
                                      </thead>
                                      <tbody>

                                      @foreach($prods as $prod )
                                      <tr>
                                              <td>{{$prod->brand}}</td>
                                              <td>{{$prod->model}}</td>
                                          </tr>
                                      @endforeach

                                      </tbody>
                                  </table>

                              </div>

                          </div>
                      </div>
                @endif
           @endforeach
          </div>
        </div>
    </div>



</div>



@include('site.partiales._contactform')
<!-- Altre società del gruppo -->

@include('site.partiales._group')
<!-- Footer -->
@include('site.partiales._footer')

<script>
    var btnMenu = document.getElementById("btnMenu");
    var menuMob = document.getElementById("menuMob");
    var closeMenu = document.getElementById("closeMenu");

    btnMenu.addEventListener("click", function () {
        menuMob.classList.add("menuOpen");
    });

    closeMenu.addEventListener("click", function () {
        menuMob.classList.remove("menuOpen");
    });

    var scrollToTopBtn = document.getElementById("scrollToTopBtn");
    var rootElement = document.documentElement;

    function scrollToTop() {
        rootElement.scrollTo({
            top: 0,
            behavior: "smooth"
        })
    }
    scrollToTopBtn.addEventListener("click", scrollToTop);
</script>
</body>

</html>
