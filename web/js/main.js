
url_parts = '';

var moduleCollection = function(){

    this.modules = new Array();
    var context = this;

    this.add = function(name, module){
        context.modules[name] = module;
    }

    this.invoke = function(name){
        if (typeof this.modules[name] === 'undefined') {
            return false;
        }

        context.modules[name]();
    }
};

var modules = new moduleCollection();

modules.add('category', function(){

    id = url_parts[1];

    var galleryContainer = $('#gallery');
    galleryContainer.html('');
    var imageWrapElement = $('<div/>', {
        'class' : 'col-md-12'
    });

    $.ajax({
        method: "GET",
        url: "/api/category/" + id
    }).done(function( data ) {

        if (data.count > 0) {


            $.each(data.images, function (id, image) {

                var fancyBoxLink = $('<a/>', {
                    'href' : '/uploads/images/' + image.path,
                    'class' : 'show-image',
                    'rel' : 'group'
                });

                var imageData = $('<img/>', {
                    'class': 'img-thumbnail b-lazy img-responsive ' + (image.hash != '' ? 'hover-title' : '').toString(),
                    'title': image.name + ' - фотограф Валентина Некрасова, Львів',
                    'hash': image.hash != '' ? image.hash : '',
                    'alt': 'фотограф Валентина Некрасова, Львів'
                });


                imageData.attr('src', '/images/placeholder.png');
                imageData.attr('data-src', '/uploads/small_images/' + image.path);
                imageData.attr('data-src-small', '/uploads/small_images/' + image.path);

                imageData.css({'height': '350px'});


                fancyBoxLink.append(imageData);

                imageWrapElement.append(
                    fancyBoxLink
                );

                galleryContainer.append(imageWrapElement);

            });



            $( '.hover-title' ).tooltip();

            $("html, body").animate({ scrollTop: galleryContainer.offset().top - 125 }, 1000);

            var bLazy = new Blazy({
                breakpoints: [{
                    src: 'data-src-small'
                }]
                , success: function (element) {

                }
            });

            $("a.show-image").fancybox(
                {'transitionIn'	:	'elastic',
                    'transitionOut'	:	'elastic',
                    'speedIn'		:	600,
                    'speedOut'		:	200,
                    'overlayShow'	:	false}
            );

        } else {
            galleryContainer.html("empty category!!!");
        }

        document.title = data.header + ' --- весільний та сімейний фотограф Валентина Некрасова';

    });

    galleryContainer.focus();
});

// for main page
modules.add('main', function(){

    var galleryContainer = $('#gallery');
    galleryContainer.html('');
    var imageWrapElement = $('<div/>', {
        'class' : 'col-md-12'
    });

    $.ajax({
        method: "GET",
        url: "/api/main/"
    }).done(function( data ) {

        if (data.count > 0) {

            $.each(data.images, function (id, image) {

                var fancyBoxLink = $('<a/>', {
                    'href' : '/uploads/images/' + image.path,
                    'class' : 'show-image',
                    'rel' : 'group'
                });

                var imageData = $('<img/>', {
                    'class': 'img-thumbnail b-lazy'
                });

                imageData.attr('src', '/images/placeholder.png');
                imageData.attr('data-src', '/uploads/small_images/' + image.path);
                imageData.attr('data-src-small', '/uploads/small_images/' + image.path);

                imageData.css({'max-height': '350px'});

                fancyBoxLink.append(imageData);

                imageWrapElement.append(
                    fancyBoxLink
                );

                galleryContainer.append(imageWrapElement);
            });

            var bLazy = new Blazy({
                breakpoints: [{
                     src: 'data-src-small'
                }]
                , success: function (element) {

                }
            });

            $("a.show-image").fancybox(
                {'transitionIn'	:	'elastic',
                    'transitionOut'	:	'elastic',
                    'speedIn'		:	600,
                    'speedOut'		:	200,
                    'overlayShow'	:	false}
            );

        } else {
            galleryContainer.html("empty category!!!");
        }

        document.title = 'Весільний та сімейний фотограф Валентина Некрасова, Львів';

    });

    galleryContainer.focus();
});


$(function(){
    $('#bs-navbar-collapse-1 a').click(function(){
        $('#bs-navbar-collapse-1 a').parent().removeClass('active');
        $(this).parent().addClass('active');
    });

    var hashCallback = function(){
        var hash = location.hash.substring(1);
        url_parts = hash.replace(/\/\s*$/,'').split('/');

        var controller = url_parts[0];

        if(controller == '') {
            controller = 'main';
        }

        modules.invoke(controller);
    };

    $(window).on('hashchange', hashCallback);

    if (location.hash == '') {
        modules.invoke('main');
    } else {
        hashCallback();
    }

    var pusher = new Pusher('7ba9ad15658d0adf9a42', {
        encrypted: true
    });

    var channel = pusher.subscribe('gallery_channel');
    channel.bind('update_images', function(data) {
        console.log(data);

        if (confirm("На сервер загружена нова колекція фото, бажаєте переглянути?")) {
            window.location.href = '/#category/' + data.category_id;
        }
    });

})
