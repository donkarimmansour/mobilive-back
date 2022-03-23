$(document).ready(function() {

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
        $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function() {
            if (this.href === path) {
                $(this).addClass("active");
            }
        });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });

    
	/* Ara YOU Sure */
$(".confirm").click(function(){
	return confirm("Ara YOU Sure");
  });

//   $(".select_image").on("click", function() { 
// 	$(".select_image").children("img").removeClass("border border-primary selected_img");
// 	$(this).children("img").addClass("border border-primary selected_img");
		
// });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#profile-img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        } 
        
        $("#file-img").change(function(){
            readURL(this);
        });

        function readURLTWO(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    $('#profile_img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file_img").change(function(){
            readURLTWO(this);
        });

        //auto_direction

        $(".auto_direction").on("keyup", function(event) { 
            
            if ($(this).val().charCodeAt(0) < 200) {
                $(this).css("direction","ltr"); 
                $(this).attr('placeholder', $(this).attr("data-msgEng"));

            } else if ($(this).val().charCodeAt(0) >= 200){
                $(this).css("direction","rtl"); 
                $(this).attr('placeholder', $(this).attr("data-msgAr"));

            } 
            
        });

        $("form .row #title").on("keyup", function() { 

            $("#output-title").text($(this).val())

            
        });

        $("form .row #message").on("keyup", function() { 

            $("#output-message").text($(this).val())
            
        });

      

});
  
