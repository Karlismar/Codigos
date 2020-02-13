        let form = $('.clone-form');
            
        $('body').on('click', '.btn-clonador', function () {
                
            let btnRemove  = $('.button-remove');
            
            $(btnRemove).removeClass('hide');
            $(form).removeClass('hide');
            $(form).clone().appendTo('.novo-form');
        
        });
        
        $(document).on('click', 'a.remove', function() {
            $(this).closest('div.clone-form').remove();
        });
