
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./react_main.js');


$(document).ready(function(){
    $(".scrollto").click(function(event) {
        event.preventDefault(); 
		alert("scroll");

        var defaultAnchorOffset = 0;

        var anchor = $(this).attr('data-attr-scroll');
alert("anchor"+anchor);
        var anchorOffset = $(anchor).attr('data-scroll-offset');
        if (!anchorOffset)
            anchorOffset = defaultAnchorOffset; 

		alert("scroll"+anchorOffset);
        $('html,body').animate({ 
            scrollTop: $(anchor).offset().top + anchorOffset
        }, 1000);        
    });
}); 



//import Contact from './react_main'; 


//require('./react_main');
//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/*Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});
*/
