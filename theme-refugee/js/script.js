var MCProcessing = false;
var IsFavPage =false;
jQuery(document).ready(function($){
	
	$("[data-toggle='collapse']").off("click");
	
	$(".navbar-search,.trigger-search").on("click",function(){$("#search-bar").modal("show");});
	
	$(".navbar-toggle").on("click",function(){
		$(".sidebar,.sidebar-cover").show();
		$("body").addClass("no-scroll");
	});
	
	$(".sidebar-close,.sidebar-cover").on('click',function(){
		$(".sidebar,.sidebar-cover").hide();
		$("body").removeClass("no-scroll");
	});
	
	$('.sidebar-scroller').jScrollPane({autoReinitialise: true});
	
	$("#mc-submit").on("click",function(){
		$(".mc-container").find(".alert").remove();
		var $email = $.trim($("#mc-email").val());
		if($email == "")
		{
			alert("Please enter a valid email!"); return false;
		}
		$("#mc-email").prop("readonly",true);
		$.trim($("#mc-email").val(""));
		$("<div class='alert alert-warning'>Processing... Give us a minute!</div>").insertBefore(".mc-container .input-group");
		$.ajax({
			url : SszarkLabs.ajaxurl,
			data : {
				action : "Hai",
				method : "MailChimp",
				email : $email
			},
			type : 'post',
			dataType : 'json',
			success : function(data)
			{
				$(".mc-container").find(".alert").remove();
				$("#mc-email").prop("readonly",false);
				$(data.msg).insertBefore(".mc-container .input-group");
			}
		});
	});
});