$(function(){
    var nbrPhoto = $('#formPhoto-fields-list').data('nbr-photo');

    /*$('.element').each(function(){
        var src = $(this).data('url');
        var label = $('label', $(this));
        //console.log(url);
        remplacerImageApercu(label, src, '');
    })*/

    $('#add-photo').click(function(e) {
        e.preventDefault();

        var photoList = $('#formPhoto-fields-list');

        // grab the prototype template
        var newWidget = photoList.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, nbrPhoto+''+Math.floor((Math.random() * 10) + 1)  );
        nbrPhoto++;

        // create a new list element and add it to the list
        var newLi = $('<li class="element"></li>').html(newWidget);
        newLi.appendTo(photoList);
        initEvenInput();
        addTagFormDeleteLink(newLi);
    });

    //--------------------------- suppression
    // Get the ul that holds the collection of tags
    $collectionHolder = $('#formPhoto-fields-list');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li.element').each(function(index) {
        if(index != 0)
        {
           addTagFormDeleteLink($(this)); 
        }
    });


    function addTagFormDeleteLink($tagFormLi) {
        var $removeFormA = $('<button class="btSupImg" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>');
        $tagFormLi.append($removeFormA);

        $removeFormA.on('click', function(e) {
            // prevent the link from creating a "#" on the URL
            e.preventDefault();

            // remove the li for the tag form
            $tagFormLi.remove();
            gestionAffichageAdd();
        });
        gestionAffichageAdd();
    }

    function gestionAffichageAdd(){
        if($('.element').length >= 2)
        {
            $("#add-photo").hide();
        }
        else{
            $("#add-photo").show();
        }
    }



    /* ============================= AFFICHE UN APERCU D'UNE IMAGE TELECHARGER */

    initEvenInput();
    function initEvenInput(){
        $("input[type='file']").change(function(){
            var element = $(this).closest('.element');
            var label = $('label', element);
            
            var fileInput = this.files[0];

            var allowedTypes = ['png', 'jpg', 'jpeg', 'gif'];

            imgType = fileInput.name.split('.');
            imgType = imgType[imgType.length - 1].toLowerCase();

            if (allowedTypes.indexOf(imgType) != -1){
                var reader = new FileReader();
                reader.addEventListener('load', function() {
                    remplacerImageApercu(label, reader.result, fileInput.name)
                });
                reader.readAsDataURL(fileInput);
            }
            else
            {
                supprimerImgLabel(label);
                alert("Ce n'est pas une image :(");
                //remplacerImageApercu(imgApercu, srcImgDefaut, 'ajouter une image')
            }
        });
    }

    function remplacerImageApercu(label, src, alt)
    {
        supprimerImgLabel(label)
        var img = $("<img src='"+src+"' alt='"+alt+"'>");
        label.append(img);
        label.removeClass('lbNoFile');
        /*imgApercu.hide(200, function(){
            imgApercu.attr('src', src);
            imgApercu.attr('alt', alt);
        }).show(200);*/
    }

    function supprimerImgLabel(label){
        $('img', label).remove();
        label.addClass('lbNoFile');
    }
})