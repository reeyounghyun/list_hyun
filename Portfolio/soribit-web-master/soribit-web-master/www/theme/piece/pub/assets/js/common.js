var Piece = window.Piece || {};
Piece = (function ($) {
    'use strict';
    var common = {
        layerOpen: function (target) {
			var el = $(target);
			el.removeClass('is-hidden').addClass('is-open');
			$('body').addClass('layer-opens');
			return false;
		},
		layerClose : function(target){
			var el = $(target);
			el.removeClass('is-open').addClass('is-hidden');
			$('body').removeClass('layer-opens');
			return false;
		},
        selectBox: function() {
            var select = $('.select_box');
            $(document).on('click', '.select_box .select_btn' ,function(){
                if( $(this).parent().hasClass('disabled')) return;
                $('.select_box').not($(this)).removeClass('on');
                $(this).parent().addClass('on');
            });
            $(document).on('click', '.select_box .item' ,function(){
                    var text = $(this).text();
                    var value = $(this).attr('name');
                    $(this).closest('.select_box').addClass('is-active').removeClass('on').find('.current').text(text);
                    $(this).closest('.select_box').children('input[type=hidden]').val(value).trigger('change');
            });
            $(document).on('click', function(e){
                var target = $(e.target);
                if( !target.hasClass('select_box') && !target.parents().hasClass('select_box') ) {
                select.removeClass('on');
                }
            });
        },
        calendarToggle: function(){
            // $(document).on('click', '.period_group input[type=radio]' ,function(){
            //     if($('input.period').is(':checked')){
            //         $(this).parent().siblings('.calendar').addClass('on')
            //     } else {
            //         $(this).parent().siblings('.calendar').removeClass('on')
            //     }
            // })
            $("input[name='wr_11']").on('change', function(){
                if($("input[name='wr_11']:checked").attr('id') === 'period'){
                    $(this).parent().siblings('.calendar').addClass('on');
                } else if($("input[name='wr_11']:checked").attr('id') === 'always'){
                    $(this).parent().siblings('.calendar').removeClass('on');
                }
            })
        },
        thumbnailUpload: function(){
            $('input[type=file]').on('change', function(){
                var fileVal = $(this).val();
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;
                var maxSize = 5 * 1024 * 1024;
                if( fileVal != "" ){
                    var ext = fileVal.split('.').pop().toLowerCase();
                    if($.inArray(ext, ['jpg','jpeg','png']) == -1) {
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('지원하는 형식의 파일이 아닙니다.');
                        $(this).val('');
                        $(this).next('.file_box').children('.delete_file').text('').removeClass('on');
                        $(this).next('.file_box').children('.placeholder').removeClass('off');
                    } else if(fileSize > maxSize){
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('파일 용량이 큽니다.');
                        $(this).val('');
                        $(this).next('.file_box').children('.delete_file').text('').removeClass('on');
                        $(this).next('.file_box').children('.placeholder').removeClass('off');
                    } else {
                        $(this).next('.file_box').children('.delete_file').text(fileName).addClass('on');
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').addClass('possible').text('업로드 가능합니다.');
                        $(this).siblings('.file_box').children('.placeholder').addClass('off');
                    }
                }
            })

            $('.delete_file').on('click',function(){
                $(this).parent('.file_box').siblings('.input_file').val('');
                $(this).text('').removeClass('on');
                $(this).parents('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('');
                $(this).siblings('.placeholder').removeClass('off');
            })
        },
        fileUpload: function(){
            $('input[type=file]').on('change', function(){
                var fileVal = $(this).val();
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;
                var maxSize = 5 * 1024 * 1024;
                if( fileVal != "" ){
                    var ext = fileVal.split('.').pop().toLowerCase();
                    if($.inArray(ext, ['jpg','jpeg','gif','png']) == -1) {
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('지원하는 형식의 파일이 아닙니다.');
                        $(this).val('');
                        $(this).next('.file_box').children('.delete_file').text('').removeClass('on');
                    } else if(fileSize > maxSize){
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('파일 용량이 큽니다.');
                        $(this).val('');
                        $(this).next('.file_box').children('.delete_file').text('').removeClass('on');
                    } else {
                        $(this).next('.file_box').children('.delete_file').text(fileName).addClass('on');
                        $(this).parent('.file_wrap').siblings('.file_guide').children('.notice').addClass('possible').text('업로드 가능합니다.');
                    }
                }
            })

            $('.delete_file').on('click',function(){
                $(this).parent('.file_box').siblings('.input_file').val('');
                $(this).text('').removeClass('on');
                $(this).parents('.file_wrap').siblings('.file_guide').children('.notice').removeClass('possible').text('');
                $(this).siblings("input[name^='bf_file_del']").val(1);
            })
        },
        init: function() {
            common.selectBox();
            common.calendarToggle();
        }
    };
    $(document).ready(function () {
        common.init();

        // if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > -1) {
        //     $('body').addClass('ie');
        // }

        // 배너 슬라이드
        if($('.banner').length > 0){
            $('.banner_slide').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                // autoplay: true,
                // autoplaySpeed: 2000,
                arrows:false
            })
        }
        // 에디터 파일첨부
        if($('.editor_file .file_wrap').length > 0){
            common.thumbnailUpload();
        }
        // 제품서비스 썸네일 업로드
        // if($('.product .file_wrap').length > 0){
        //     common.thumbnailUpload();
        // }
        // 회원가입 파일 업로드
        if($('.join .file_wrap').length > 0){
            common.fileUpload();
        }
        // 기간 선택
        if($("input[name='wr_11']:checked").attr('id') === 'period'){
            $('.calendar').addClass('on');
        } else if($("input[name='wr_11']:checked").attr('id') === 'always'){
            $('.calendar').removeClass('on');
        }
    });

    return {
        layerOpen: common.layerOpen,
        layerClose: common.layerClose,
    };
})($);

var validation = {
    id: /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i,
    password: /^.{8,15}$/,
    number:/^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/
    // /^[0-9]{2,3}-[0-9]{3,4}-[0-9]{4}/
    // /^(070|02|0[3-9]{1}[0-9]{1})[0-9]{3,4}[0-9]{4}$/
};
