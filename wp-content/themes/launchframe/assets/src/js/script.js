(function($, w){
    "use strict";
    /* global
     * console, setTimeout */

var theWindow = $(window);
var wb = {
	mobileNavTrigger: {
        test: function() {
            return true;
        },
        run: function() {
        	console.log("click");
        	var body = $("body");
        	$(body).addClass("nav-open");
        	$("nav .trigger").on("click", function() {
        		console.log("click");
        		$(body).toggleClass("nav-open");
        	});
        }
    }
};

Object.keys(wb).forEach(function(key){
    if (wb[key].test()){ wb[key].run(); }
});

}(jQuery, window));
