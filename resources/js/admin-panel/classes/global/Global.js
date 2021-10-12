export default class Global {

    constructor() {
        this.noImage();
        this.sidebar();
        this.showHideCheckboxesOrRadio();
        this.initCKEditor();
        this.iosCheckbox();
        this.preloaderAnimation();
        this.mobileTabs();
    }

    noImage() {
        $("img").on("error", function(){
            $(this).attr("src", "/images/admin-panel/no-image.png");
        });
        $(document).ajaxComplete(function(){
            $("img").off("error");
            $("img").on("error", function(){
                $(this).attr("src", "/images/admin-panel/no-image.png");
            });
        });
    }

    sidebar() {
        if(breakpoint("sm")){
            $("body").removeClass("fixed");
        }else if(breakpoint("sm")){
        }else if(breakpoint("md")){
            $(".sidebar-toggle").trigger("click");
        }
    }

    showHideCheckboxesOrRadio() {
        if($('[data-enable], [data-disable]').length){
            $(document).on("click", '[data-enable]', function(){
                let fieldsToEnable = $(this).data("enable");
                $.each(fieldsToEnable, function(i, item){
                    $("[name='" + item + "']").prop("disabled", false);
                });
            });
            $("[data-enable]:checked").trigger("click");
            $(document).on("click", '[data-disable]', function(){
                let fieldsToDisable = $(this).data("disable");
                $.each(fieldsToDisable, function(i, item){
                    $("[name='" + item + "']").prop("disabled", true);
                });
            });
            $("[data-disable]:checked").trigger("click");
        }
    }

    initCKEditor() {
        $('.editor').each(function(index, item) {
            ClassicEditor
                .create( document.querySelector( '#' + $(item).attr("id") ), {
                    language: $("html").attr("lang"),
                    toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote' ],
                    heading: {
                        options: [
                            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                            { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                            { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                        ]
                    }
                })
                .catch( error => {
                    console.error( error );
                });
        });
    }

    iosCheckbox() {
        $(".ios-checkbox").iosCheckbox();
    }

    preloaderAnimation() {
        new WOW.WOW({ mobile: false }).init();

        $("#status").fadeOut();
        $("#preloader").fadeOut("slow");

        if(window.location.hash){
            $('html, body').animate({
                scrollTop: $(window.location.hash).offset().top
            }, 500);
        }
    }

    mobileTabs() {
        if(breakpoint("xs")){
            $('.nav-tabs').slick({
                infinite: false,
            });
            $('.nav-tabs').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                var tabID = $(slick.$slides[nextSlide]).find("a").attr("href");
                var tab = $(tabID);
                $(slick.$slides[nextSlide]).find("a").trigger("click");
                $('.tab-pane').removeClass("active");
                $('.tab-pane').hide();
                tab.addClass('active');
                tab.fadeIn();
                tab.animate({
                    scrollTop: 0
                });
            });
        }
    }
}
