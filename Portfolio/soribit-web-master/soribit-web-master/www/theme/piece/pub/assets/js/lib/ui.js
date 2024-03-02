$('.input-box input, .input-box textarea').on({
    focus(){
        $(this).parent('.input-box').addClass('focus')
    },
    focusout(){
        $(this).parent('.input-box').removeClass('focus')
    }
})