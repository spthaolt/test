Ossn.RegisterStartupFunction(function() {
    $(document).ready(function() {
        if ($('#event-location-input').length) {
 			$('#event-location-input').autocomplete({
                source: function(request, response) {
                    jQuery.getJSON(
                        "http://gd.geobytes.com/AutoCompleteCity?callback=?&sort=size&q=" + request.term,
                        function(data) {
                            response(data);
                        }
                    );
                },
                minLength: 3,
                select: function(event, ui) {
                    var selectedObj = ui.item;
                    $('#event-location-input').val(selectedObj.value);
                    $(".ui-menu-item").hide();
                    return false;
                },
                open: function() {
                    jQuery(this).removeClass("ui-corner-all").addClass("ui-corner-top");
                },
                close: function() {
                    jQuery(this).removeClass("ui-corner-top").addClass("ui-corner-all");
                }
            });
            $('#event-location-input').autocomplete("option", "delay", 100);
        }
     	$('body').on('click', '.event-relation', function(){
        		$guid = $(this).attr('data-guid');
        		$type = $(this).attr('data-type');
                Ossn.MessageBox('event/relations/'+$guid+'?type='+$type);
        });
    });
});