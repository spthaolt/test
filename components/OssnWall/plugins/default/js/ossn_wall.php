/**
 * 	Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright 2014-2017 SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence 
 * @link      https://www.opensource-socialnetwork.org/
 */
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        $('.ossn-wall-container').find('.ossn-wall-friend').click(function() {

            $('#ossn-wall-friend').show();
        });
        $('.ossn-wall-container').find('.ossn-wall-location').click(function() {

            $('#ossn-wall-location').show();
        });
        $('.ossn-wall-container').find('.ossn-wall-photo').click(function() {

            $('#ossn-wall-photo').show();
            $('#fileupload').click();

        });
        $('body').on('click', '.ossn-wall-container-menu-post', function(e){
        	e.preventDefault();
            $('.ossn-wall-container-data-post').hide();
            $('.ossn-wall-container-data-post').show();
        });
        $('body').on('click', '.ossn-wall-post-delete', function(e) {
            $url = $(this);
            e.preventDefault();
            Ossn.PostRequest({
                url: $url.attr('href'),
                beforeSend: function(request) {
                    $('#activity-item-' + $url.attr('data-guid')).attr('style', 'opacity:0.5;');
                },
                callback: function(callback) {
                    if (callback == 1) {
                        $('#activity-item-' + $url.attr('data-guid')).fadeOut();
                        $('#activity-item-' + $url.attr('data-guid')).remove();
                    } else {
                        $('#activity-item-' + $url.attr('data-guid')).attr('style', 'opacity:1;');
                    }
                }
            });
        });

        $('body').delegate('.ossn-wall-post-edit', 'click', function() {
            var $dataguid = $(this).attr('data-guid');
            Ossn.MessageBox('post/edit/' + $dataguid);
        });
    });

});
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        if ($.isFunction($.fn.tokenInput)) {
            $("#ossn-wall-friend-input").tokenInput(Ossn.site_url + "friendpicker", {
                placeholder: Ossn.Print('tag:friends'),
                hintText: false,
                propertyToSearch: "first_name",
                resultsFormatter: function(item) {
                    return "<li>" + "<img src='" + item.imageurl + "' title='" + item.first_name + " " + item.last_name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name' style='font-weight:bold;color:#2B5470;'>" + item.first_name + " " + item.last_name + "</div></div></li>"
                },
                tokenFormatter: function(item) {
                    return "<li><p>" + item.first_name + " " + item.last_name + "</p></li>"
                },
            });
        }
    });
});
Ossn.PostMenu = function($id) {
    $element = $($id).find('.menu-links');
    if ($element.is(":not(:visible)")) {
        $element.show();
    } else {
        $element.hide();
    }
};
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        $('.ossn-wall-privacy').on('click', function(e) {
            Ossn.MessageBox('post/privacy');
        });
        $('#ossn-wall-privacy').on('click', function(e) {
            var wallprivacy = $('#ossn-wall-privacy-container').find('input[name="privacy"]:checked').val();
            $('#ossn-wall-privacy').val(wallprivacy);
            Ossn.MessageBoxClose();
        });
        //ajax post
        $url = $('#ossn-wall-form').attr('action');
        Ossn.ajaxRequest({
            url: $url,
            action: true,
            containMedia: true,
            form: '#ossn-wall-form',

            beforeSend: function(request) {
                var $file = $("#ossn-wall-form").find("input[type='file']");
                $file.val('');
                $('#ossn-wall-form').find('input[type=submit]').hide();
                $('#ossn-wall-form').find('.ossn-loading').removeClass('ossn-hidden');
            },
            callback: function(callback) {
                if (callback['success']) {
                    Ossn.trigger_message(callback['success']);
                    if (callback['data']['post']) {
                        $('.user-activity').prepend(callback['data']['post']).fadeIn();
                    }

                    //remove file add
                    $("#ossn-wall-form").find(".file-wrapper").remove();
                }
                if (callback['error']) {
                    Ossn.trigger_message(callback['error'], 'error');
                }

                //need to clear file path after uploading the file #626
                var $file = $("#ossn-wall-form").find("input[type='file']");
                $file.val('');

                // $file.replaceWith($file.val('').clone(true));
                $('#ossn-wall-photo').hide();

                //Tagged friend(s) and location should be cleared, too - after posting #641
                $("#ossn-wall-location-input").val('');
                $('#ossn-wall-location').hide();
     
                $('#ossn-wall-friend-input').val('');
                if($('#ossn-wall-friend-input').length){
	                $("#ossn-wall-friend-input").tokenInput("clear");
	                $('#ossn-wall-friend').hide();
                }

                $('#ossn-wall-form').find('input[type=submit]').show();
                $('#ossn-wall-form').find('.ossn-loading').addClass('ossn-hidden');
                $('#ossn-wall-form').find('textarea').val("");
                $('#ossn-wall-form').find('.ossn-wall-product').remove();
            }
        });
    });

});
/**
 * Setup Google Location input
 *
 * Remove google map search API as it requires API #906 
 * 
 * @return void
 */
Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        if ($('#ossn-wall-location-input').length) {
            //Location autocomplete not working over https #1043
            //Change to places js
            var placesAutocomplete = places({
                container: document.querySelector('#ossn-wall-location-input')
            });
        }
    });
});

Ossn.RegisterStartupFunction(function() {

    if (typeof $('#fileupload') != 'undefined')
        $(document).ready(function() {

            var process_url = "<?php echo ossn_site_url()?>postphotos/upload";
            var delete_url = "<?php echo ossn_site_url()?>postphotos/delete";

            $('#fileupload').fileupload({
                url: process_url,
                dataType: 'json',
                autoUpload: true,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                previewMaxWidth: 100,
                previewMaxHeight: 100,
                previewCrop: true
            }).on('fileuploadadd', function (e, data) {

                data.context = $('<div/>').addClass('file-wrapper').appendTo('#files');

                $.each(data.files, function (index, file) {
                    var node = $('<div/>').addClass('file-row');

                    var hover  = $('<div style="display:none;cursor: pointer;"/>').addClass('upload-hover-remove');
                    var removeBtn  = $('<a/>').addClass('upload-remove').append('<i class="fa fa-times" aria-hidden="true"/>');

                    hover.append(removeBtn);

                    // show hile btn close
                    $(".file-wrapper").hover(function() {
                        $(this).find(".upload-hover-remove").show();
                    }, function() {
                        $(this).find(".upload-hover-remove").hide();
                    });   

                    // event click
                    removeBtn.on('click', function(e, data){
                        var imageId = $(this).parent().parent().find("#imageId").val();

                        Ossn.PostRequest({
                            url: delete_url +"/"+ imageId,
                            action: false,
                            callback: function(callback) {
                                
                            }
                        });
                        $(this).parent().parent().remove();
                    });

                    node.append('<div class="circle"/>');
                    node.append(hover);      
                    node.appendTo(data.context);
                });

                $("#files").prepend(data.context);
                $('.circle').progressCircle({
                    nPercent        : 0,
                    showPercentText : false,
                    circleSize      : 111,
                    thickness       : 3
                });

            }).on('fileuploadprocessalways', function (e, data) {
                var index = data.index,
                    file = data.files[index],
                    node = $(data.context.children()[index]);

                if (file.preview) {
                    node
                        .prepend('<br>')
                        .prepend(file.preview);
                }
                if (file.error) {
                    node
                        .append('<br>')
                        .append($('<span class="text-danger"/>').text(file.error));
                }
            }).on('fileuploadprogress', function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                if (data.context) {
                    data.context.each(function () {
                        $(this).find('.circle').children().first().progressCircle({ 
                                                                    nPercent : progress ,
                                                                    showPercentText : false,
                                                                    circleSize      : 111,
                                                                    thickness       : 3
                                                                });
                    });
                }
            }).on('fileuploaddone', function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $(data.context.children()[index]).find('.circle').remove();   

                    if (file.url) {
                        var link = $('<a>') .attr('target', '_blank') .prop('href', file.url);

                        //$(data.context.children()[index]).find('canvas').wrap(link);        
                    } else if (file.error) {
                        $(data.context.children()[index])
                            .append('<br>')
                            .append(error);
                    }

                    if(file.name) {
                        var hiddenName = $('<input />')
                            .prop('id', 'imageId')
                            .prop('type', 'hidden')
                            .prop('name', 'ossn_photo[]')
                            .val(file.name);

                        $(data.context.children()[index]).append(hiddenName);     
                    }
        
                });

                // Scroll
                $(".files").animate({ scrollLeft: $(".files")[0].scrollWidth}, 1000);

            }).on('fileuploadfail', function (e, data) {
                $.each(data.files, function (index) {
                    $(data.context.children()[index]).find('.circle').remove();
                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                });
            }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');

            });
}); 
